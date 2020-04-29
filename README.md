![DiegoDev Labs](https://dl.dropboxusercontent.com/s/3fufybtdhru6mhb/DiegoLabs%20Logo.png)

# DiegoLabs UUID Package

Simple package to allow you to add UUID to Laravel Models via a trait. 

## Traits
* __SetsUuidWhenCreating__ - This sets the primary key of the model to a UUID. It allows you to pass a UUID if 
you have a workflow that creates a UUID by default. If the UUID is version 4 compliant, then the trait will 
just us the UUID passed to it. We use this from time to time when records are created on a mobile device then
passed to a backend via an API. They may already have a UUID associated with it. 

## Useage 

ID must be configured in the database to accept a UUID. 

For Migrations:
``` 
public function up()
{
    Schema::create('your_models', function (Blueprint $table) {
        $table->uuid('id'); // Set to uuid
        $table->string('name');
        $table->timestamps();
        $table->primary('id'); // Add primary key
    });
}
```
For Models:
```
use Ddlabs\Uuid\Traits\SetsUuidWhenCreating;

class YourModel extends Model
{
    use SetsUuidWhenCreating;

    public $incrementing = false;

    protected $keyType = 'string';
   ...
}
```