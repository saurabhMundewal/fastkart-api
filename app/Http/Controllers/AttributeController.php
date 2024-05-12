<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Attribute;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\GraphQL\Exceptions\ExceptionHandler;
use App\Http\Requests\CreateAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Repositories\Eloquents\AttributeRepository;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public $repository;

    public function __construct(AttributeRepository $repository)
    {
        $this->authorizeResource(Attribute::class, 'attribute', [
            'except' => [ 'index', 'show' ],
        ]);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $attribute = $this->filter($this->repository->with(['attribute_values']), $request);
            return $attribute->latest('created_at')->paginate($request->paginate ?? $this->repository->count());

        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAttributeRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        return $this->repository->show($attribute->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function attributesUsedInProducts($cat)
    {
        // $attributes = Variation::has('product_id')->get();
        //$abc = $this->repository->with(['variations'], Attribute::has('products'))->get();
        $jsonResult = DB::table('attribute_values as av')
        ->select(
            'av.id as attribute_value_id',
            'av.value',
            'av.slug',
            DB::raw('MAX(vav.id) as variation_attribute_value_id'),
            DB::raw('MAX(vav.variation_id) as variation_id'),
            DB::raw('MAX(v.id) as variation_id'),
            DB::raw('MAX(v.name) as name'),
            DB::raw('MAX(v.variation_options) as variation_options'),
            DB::raw('MAX(v.product_id) as product_id'),
            'a.id as attribute_id',
            'a.name as attribute_name',
            'a.style',
            'a.slug as attribute_slug',
            'a.status as attribute_status', 
            'a.created_by_id as attribute_created_by_id',
            'a.created_at as attribute_created_at',
            'a.updated_at as attribute_updated_at',
            'a.deleted_at as attribute_deleted_at',
            'p.category_id',
            'c.slug' // Select all columns from the categories table
        )
        ->join('variation_attribute_values as vav', 'av.id', '=', 'vav.attribute_value_id')
        ->join('variations as v', 'vav.variation_id', '=', 'v.id')
        ->join('attributes as a', 'av.attribute_id', '=', 'a.id')
        ->join('product_categories as p', 'v.product_id', '=', 'p.product_id') // Joining product_categories table
        ->join('categories as c', 'p.category_id', '=', 'c.id') // Joining categories table
        ->whereIn('c.slug', $cat)
        ->groupBy(
            'av.id', 'av.value', 'av.slug','p.category_id',
            'a.id', 'a.name', 'a.style', 'a.slug', 'a.status', 'a.created_by_id', 'a.created_at', 'a.updated_at', 'a.deleted_at',
            'p.product_id', // Group by product_id
            'c.slug as category_slug' // Group by category_id
        )
        ->get();
    
      
       // Decode the JSON result
       // Decode the JSON result
$results = json_decode($jsonResult, true);
dd($results);
// Initialize an empty array to store the transformed data
$transformedData = [];

// Iterate over the results
foreach ($results as $result) {
    // Extract attribute details
    $attribute = [
        'id' => $result['attribute_id'],
        'name' => $result['attribute_name'],
        'style' => $result['style'],
        'slug' => $result['attribute_slug'],
        'status' => $result['attribute_status'],
        'created_by_id' => $result['attribute_created_by_id'],
        'created_at' => $result['attribute_created_at'],
        'updated_at' => $result['attribute_updated_at'],
        'deleted_at' => $result['attribute_deleted_at'],
    ];

    // Extract attribute value details
    $attributeValue = [
        'id' => $result['attribute_value_id'],
        'value' => $result['value'],
        'slug' => $result['slug'], // You may need to generate a unique slug
        'hex_color' => null, // Fill this with appropriate value if available
        'attribute_id' => $result['attribute_id'],
        'created_by_id' => $result['attribute_created_by_id'],
        'created_at' => $result['attribute_created_at'],
        'updated_at' => $result['attribute_updated_at'],
        'deleted_at' => $result['attribute_deleted_at'],
    ];

    // Add attribute value to the corresponding attribute
    if (!isset($transformedData[$attribute['id']])) {
        // Initialize the attribute with its value array if not already exists
        $transformedData[$attribute['id']] = $attribute;
        $transformedData[$attribute['id']]['attribute_values'] = [];
    }

    // Add attribute value to the attribute's value array
    $transformedData[$attribute['id']]['attribute_values'][] = $attributeValue;
}

// Convert the array to JSON
$transformedJson = json_encode(array_values($transformedData), JSON_PRETTY_PRINT);

//$arrayResult = json_decode($transformedData, true);

// Extract the values from the associative array
$cleanedResult = array_values($transformedData);
// Output the transformed JSON
return response()->json($cleanedResult);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        return $this->repository->update($request->all(), $attribute->getId($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Attribute $attribute)
    {
        return $this->repository->destroy($attribute->getId($request));
    }

    /**
     * Update Status the specified resource from storage.
     *
     * @param  int  $id
     * @param int $status
     * @return \Illuminate\Http\Response
     */
    public function status($id, $status)
    {
        return $this->repository->status($id, $status);
    }

    public function deleteAll(Request $request)
    {
        return $this->repository->deleteAll($request->ids);
    }

    public function getAttributesExportUrl(Request $request)
    {
        return $this->repository->getAttributesExportUrl($request);
    }

    public function import()
    {
        return $this->repository->import();
    }

    public function export()
    {
        return $this->repository->export();
    }

    public function filter($attribute, $request)
    {
        if ($request->field && $request->sort) {
           $attribute = $attribute->orderBy($request->field, $request->sort);
        }

        if (isset($request->status)) {
            $attribute = $attribute->whereStatus($request->status);
        }

        if ($request->store_slug) {
            $store_slug = $request->store_slug;
            $attribute = $attribute->whereHas('products', function (Builder $products) use ($store_slug) {
                $products->whereHas('store', function (Builder $store) use ($store_slug) {
                    $store->where('slug', $store_slug);
                });
            });
        }

        return $attribute;
    }
}
