<?php

namespace App\Http\Controllers;

use App\User;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //dd($clients);

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
        //
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
        $corporateClients = \App\CoporateClient::all();
        //return view('includes.view-corporate-client',array("cclients" => $corporateClients));
        $user = \Auth::user();
        //  dd($user);
        return view('clients.view-corporate-client')->with(['user' => $user, 'clients' => $corporateClients]);
    }


    public function addNewCorporateClient()
    {
        $user = \Auth::user();
        return view('clients.addnew')->with(['user' => $user]);
    }

    public function createCorporateClient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'businessname' => 'required',
            'contactno' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
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
            'logo' => $request->input('logo'),
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

    public function getUsers()
    {
        $clients = CoporateClient::all();
        return Datatables::of($clients)->addColumn('actions', function ($data) {
            return '<a href="' . url('admin/corporate-client/' . $data->id . '/edit') . '" class="btn btn-primary btn-sm">Edit</a>
                    <a href="' . url('admin/corporate-client/' . $data->id) . '" class="btn btn-danger btn-sm">Delete</a>';
        })->make(true);
    }

    public function delete($id)
    {
        $clients = CoporateClient::find($id);
        $clients->delete();

        return redirect()->route('corporate.clients');
    }

}
