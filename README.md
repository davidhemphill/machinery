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

First, create an enumeration that represents the states you wish to 
model and the valid transitions between them:

```php
use Hemp\Machinery\MachineryState;
use Hemp\Machinery\MachineryEnumeration;

enum OrderStatus: string implements MachineryState
{
    use MachineryEnumeration;

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

Now you can use the `OrderStatus` enumeration to manage transitions 
between states:

```php
use Hemp\Machinery\Machinery;

OrderStatus::Processing->canTransitionTo(OrderStatus::Shipped); // true
OrderStatus::Processing->transitionTo(OrderStatus::Shipped); // state is now 'shipped'

OrderStatus::Shipped->canTransitionTo(OrderStatus::Delivered); // true
OrderStatus::Shipped->transitionTo(OrderStatus::Delivered); // state is now 'delivered'

OrderStatus::Delivered->canTransitionTo(OrderStatus::Processing); // 
OrderStatus::Delivered->transitionTo(OrderStatus::Processing); // Throws an exception...
```

## Using the state machine with Eloquent

Next, add a column to your Eloquent model's `casts` to store the state:

```php
use Hemp\Machinery\Machinery;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
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

$order->status->transitionTo('status', OrderStatus::Shipped, function (Order $order) {
    // Perform any side effects that need to happen before
    // the state change is persisted to the database...
    $order->status_changed_at = now();
});

$order->status->is(OrderStatus::Shipped); // true

$order->status->canTransitionTo('status', OrderStatus::Processing); // false

$order->status->transitionTo('status', OrderStatus::Delivered); // Throws an exception...
```
