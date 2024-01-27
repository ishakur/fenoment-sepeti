<?php

namespace App\Http\Controllers\Api;

use App\Enum\Http;
use App\Exceptions\NotFound;
use App\Exceptions\StoreFailed;
use App\Models\Navbar;
use Exception;
use Illuminate\Http\Request;

class NavbarController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $navbar = Navbar::all()->count(10);
        if (!$navbar)
            throw new NotFound('navbarItems');

        return $this->apiResponse($navbar, $this->getTextFromControllerLanguageFile('showSuccess', 'navbarItems'), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $navbar             = new Navbar();
        $navbar->name       = $request->name;
        $navbar->route_name = $request->route_name;
        $navbar->created_at = now();
        $navbar->updated_at = now();
        $navbar->save();

        if ($navbar)
            throw new StoreFailed('navbarItems');

        return self::apiResponse($navbar, $this->getTextFromControllerLanguageFile('storeSuccess', 'navbar'), Http::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        $link = Navbar::find($id);
        $link->delete();
        return $this->apiResponse($link, $this->getTextFromControllerLanguageFile('deleteSuccess', 'navbarItem'), 200);


    }
}
