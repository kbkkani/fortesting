<?php

namespace App\Http\Controllers;

use App\User;
use Storage;
use App\CoporateClient;
use App\SubDomain;
use Dompdf\Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Yajra\Datatables\Datatables;
use Validator;

class CorporateclientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = \Auth::user();
        return view('clients.view-corporate-client')->with(['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        return view('clients.addnew')->with(['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'businessname' => 'required',
            'contactno' => 'required',
            'email' => 'required|email',
            'logo_image' => 'image|max:1999',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        if($request->hasFile('logo_image')){

            //$file = Input::file('logo_image');

            //Get file name with extension
            $fileNameWithExt = $request->file('logo_image')->getClientOriginalName();

            //Get just file name
            $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

            //Get just extention
            $extention = $request->file('logo_image')->getClientOriginalExtension();

            //File name to store
            $fileNameToStore = strtolower($filename.'_'.time().'.'.$extention);

            //Upload image
            //$path = $request->file('logo_image')->storeAs('public/logo',$fileNameToStore);
            $request->file('logo_image')->move('logo' , $fileNameToStore);


        }else{
            $fileNameToStore = 'noimage.jpg';
        }


        $lastid = CoporateClient::create([
            'business_name' => $request->input('businessname'),
            'contact_no' => $request->input('contactno'),
            'email' => $request->input('email'),
            'pointof_fname_and_lastname' => $request->input('fnameandlname'),
            'pointof_email' => $request->input('pemail'),
            'prefix_code' => $request->input('prefixcode'),
            'isage' => $request->input('isage'),
            'agreement_text' => $request->input('agreement'),
            'logo' => $fileNameToStore,
            'header_color' => $request->input('headercolor'),
            'footer_color' => $request->input('footercolor'),
        ]);


        $alldomains = $request->input('subdomains');
        $domains = explode(',', $alldomains[0]);
        foreach ($domains as $domain) {

            SubDomain::create([
                'client_id' => $lastid,
                'domain_url' => $domain
            ]);

        }

        return redirect()->route('corporate.clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::user();
        $clients = CoporateClient::find($id);


        return view('clients.edit')->with(['user' => $user,'clients'=>$clients]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $clients = CoporateClient::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'businessname' => 'required',
            'contactno' => 'required',
            'email' => 'required|email',
            'logo_image' => 'image|max:1999',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if(\File::exists(public_path('logo/'.$clients->logo))){

            \File::delete(public_path('logo/'.$clients->logo));
            if($request->hasFile('logo_image')){

                //$file = Input::file('logo_image');

                //Get file name with extension
                $fileNameWithExt = $request->file('logo_image')->getClientOriginalName();

                //Get just file name
                $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

                //Get just extention
                $extention = $request->file('logo_image')->getClientOriginalExtension();

                //File name to store
                $fileNameToStore = strtolower($filename.'_'.time().'.'.$extention);

                //Upload image
                //$path = $request->file('logo_image')->storeAs('public/logo',$fileNameToStore);
                $request->file('logo_image')->move('logo' , $fileNameToStore);
            }else{
                $fileNameToStore = $request->input('old_logo');
            }
        }else{

            if($request->hasFile('logo_image')){
                //$file = Input::file('logo_image');
                //Get file name with extension
                $fileNameWithExt = $request->file('logo_image')->getClientOriginalName();

                //Get just file name
                $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

                //Get just extention
                $extention = $request->file('logo_image')->getClientOriginalExtension();

                //File name to store
                $fileNameToStore = strtolower($filename.'_'.time().'.'.$extention);

                //Upload image
                //$path = $request->file('logo_image')->storeAs('public/logo',$fileNameToStore);
                $request->file('logo_image')->move('logo' , $fileNameToStore);
            }else{
                $fileNameToStore = $request->input('old_logo');
            }
        }

        $client= CoporateClient::find($id);

        $client->business_name = $request->input('businessname');
        $client->contact_no = $request->input('contactno');
        $client->email = $request->input('email');
        $client->pointof_fname_and_lastname = $request->input('fnameandlname');
        $client->pointof_email = $request->input('pemail');
        $client->prefix_code = $request->input('prefixcode');
        $client->isage = $request->input('isage');
        $client->agreement_text = $request->input('agreement');
        $client->logo = $fileNameToStore;
        $client->header_color = $request->input('headercolor');
        $client->footer_color = $request->input('footercolor');

        $client->save();

        //$c= CoporateClient::find($id)->subDomains;
      //  dd($c);
      //  $c->delete();

//        $c = SubDomain::find(['client_id'=>$id]);
//        dd($c);


        $alldomains = $request->input('subdomains');
        $domains = explode(',', $alldomains[0]);
        foreach ($domains as $domain) {

            SubDomain::create([
                'client_id' => $id,
                'domain_url' => $domain
            ]);

        }

        return redirect()->route('corporateclient.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clients = CoporateClient::find($id);
        $clients->delete();

        return Redirect::to('clients');
    }


    public function allCorporateClients()
    {

    }


    public function addNewCorporateClient()
    {

    }

    public function createCorporateClient(Request $request)
    {



    }

    public function getUsers()
    {
        $clients = CoporateClient::all();
        return Datatables::of($clients)->addColumn('actions', function ($data) {
            return '<a href="' . url('corporateclient/' . $data->id . '/edit') . '" class="btn btn-primary btn-sm">Edit</a>
                    <a href="' . url('corporateclient/' . $data->id) . '" class="btn btn-danger btn-sm">Delete</a>';
        })->make(true);
    }

    public function delete($id)
    {
        $clients = CoporateClient::find($id);
        $clients->delete();

        return redirect()->route('corporate.clients');
    }

}
