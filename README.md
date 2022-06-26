# Resource Typeable support

This package extends the Laravel resource to separate it into types.

## Installation

Require this package with composer:

```bash
composer require aqjw/resource-typeable
```

## Usage

To turn your resource into typeable, just use `ResourceTypeable` trait.

```php
use Aqjw\ResourceTypeable\ResourceTypeable;
...
class ProductResource extends JsonResource
{
    use ResourceTypeable;
...
```

Now your resource has typeable capabilities.

## Example

```php
use Aqjw\ResourceTypeable\ResourceTypeable;
...
class ProductResource extends JsonResource
{
    use ResourceTypeable;

    /**
     * Tiny product resource
     * 
     * @return array
     */
    public function tiny($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
        ];
    }

    /**
     * Full product resource
     * 
     * @return array
     */
    public function full($request): array
    {
        return array_merge(
            $this->tiny($request),
            [
                'brand' => $this->brand,
                'model' => $this->model,
                'material' => $this->material,
                'size' => $this->size,
                'tags' => $this->tags,
                'color' => $this->color,
                'print' => $this->print,
            ],
        );
    }
}
```

In the controller, you can call the resource as before.

```php
...
class ProductController extends Controller
{
    ...
    public function index()
    {
        $products = Product::paginate(9);

        return new ProductCollection($products); // will return tiny resource type
        // or
        return ProductCollection::make($products); // will return tiny resource type
        // or
        return ProductResource::collectionType('full', $products); // will return full resource type
    }
    ...
```

One more example:

```php
...
class ProductController extends Controller
{
    ...
    public function show(Product $product)
    {
        return ProductResource::makeType('full', $product);
    }
    ...
```

## Configuration

By default the resource type is `tiny`, but you can change it with `$resource_type` variable declaration:

```php
use Aqjw\ResourceTypeable\ResourceTypeable;
...
class ProductResource extends JsonResource
{
    use ResourceTypeable;

    /**
     * Resource type
     * 
     * @var string
     */
    protected static $resource_type = 'full';
    ...
```

## Tips

Resource types are unlimited, you can create any names for them, not just `tiny` and `full`.
But keep in mind that they should not override the parent's methods.

## License

The MIT License (MIT). Please see License File for more information.
