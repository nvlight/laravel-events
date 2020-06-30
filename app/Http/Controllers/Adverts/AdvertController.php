<?php

namespace App\Http\Controllers\Adverts;

use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Category;
use App\Models\Region;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Router\AdvertsPath;
use App\Http\Requests\Adverts\SearchRequest;
use App\UseCases\Adverts\SearchService;
//use App\ReadModel\AdvertReadRepository; ?
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;

class AdvertController extends Controller
{
    private $search;

    public function __construct(SearchService $search)
    {
        $this->search = $search;
    }

    //public function index(Region $region = null, Category $category = null)
    public function index(SearchRequest $request, AdvertsPath $path)
    {
        $region = $path->region;
        $category = $path->category;

        //$query = Advert::active()->with(['category', 'region'])->orderByDesc('published_at');

//        if ($category = $path->category) {
//            $query->forCategory($category);
//        }
//
//        if ($region = $path->region) {
//            $query->forRegion($region);
//        }

//        $regions = $region
//            ? $region->children()->orderBy('name')->getModels()
//            : Region::roots()->orderBy('name')->getModels();
//
//        $categories = $category
//            ? $category->children()->defaultOrder()->getModels()
//            : Category::whereIsRoot()->defaultOrder()->getModels();

        $result = $this->search->search($category, $region, $request, 20, $request->get('page', 1));
        $adverts = $result->adverts;
        $regionsCounts = $result->regionsCounts;
        $categoriesCounts = $result->categoriesCounts;

        //$adverts = $query->paginate(20);
        //$adverts = $this->search->search($category, $region, $request, 20, $request->get('page', 1));

        $query = $region ? $region->children() : Region::roots();
        $regions = $query->orderBy('name')->getModels();

        //return view('adverts.index', compact('category', 'region', 'categories', 'regions', 'adverts'));

        $query = $category ? $category->children() : Category::whereIsRoot();
        $categories = $query->defaultOrder()->getModels();

        $regions = array_filter($regions, function (Region $region) use ($regionsCounts) {
            return isset($regionsCounts[$region->id]) && $regionsCounts[$region->id] > 0;
        });

        $categories = array_filter($categories, function (Category $category) use ($categoriesCounts) {
            return isset($categoriesCounts[$category->id]) && $categoriesCounts[$category->id] > 0;
        });

        return view('adverts.index', compact(
            'category', 'region',
            'categories', 'regions',
            'regionsCounts', 'categoriesCounts',
            'adverts'
        ));
    }

    public function show(Advert $advert)
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        //return view('adverts.show', compact('advert'));

        $user = Auth::user();

        return view('adverts.show', compact('advert', 'user'));
    }

    public function phone(Advert $advert): string
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        return $advert->user->phone;
    }
}