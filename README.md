# HEMP Machinery 📠

Machinery is tiny state machine package for Laravel. It allows you 
to manage a state machine for an attribute on one of your Eloquent 
models using PHP enumerations. 

Machinery gives your backed enumeration superpowers by allowing you 
to specify the valid transitions between states.

## Installation

You can install the package via composer:

```bash
composer require hemp/machinery
```

## Usage

First, create an enumeration that represents the states for your Eloquent model and the valid transitions between them:

```php
use Hemp\Machinery\MachineState;
use Hemp\Machinery\MachineStateTrait;

enum OrderStatus: string implements MachineState
{
    use MachineStateTrait;

    case Processing : 'processing';
    case Shipped : 'shipped';
    case Delivered : 'delivered';
    
    public static function transitions(): array
    {
        return [
            self::Processing->value => [
                self::Shipped
            ],
            self::Shipped->value => [
                self::Delivered
            ],
            self::Delivered->value => [
                // This is the final state...
            ]
        ];
    }
}
```

Next, add a column to your Eloquent model's `casts` to store the state:

```php
use Hemp\Machinery\Machinable;
use Hemp\Machinery\Machinery;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements Machinable
{
    use Machinery;

    protected $casts = [
        'status' => OrderStatus::class
    ];
}
```

Now you can use the `OrderStatus` enumeration to manage the state of your `Order` model:

```php
$order = Order::create([
    'status' => OrderStatus::Processing
]);

$order->status->is(OrderStatus::Processing); // true
$order->status->canTransitionTo(OrderStatus::Shipped); // true

$order->status->transitionTo('status', OrderStatus::Shipped, function () {
    // Perform any actions that need to be done when the state changes...
});

$order->status->is(OrderStatus::Shipped); // true

$order->status->canTransitionTo('status', OrderStatus::Processing); // false

$order->status->transitionTo('status', OrderStatus::Delivered); // Throws an exception...
```
