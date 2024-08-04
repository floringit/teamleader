# Discount Microservice

PHP REST microservice built with the Slim 4 framework. The microservice implements a flexible discount system.

## Features

- **Total Revenue Discount**: A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
- **Switches Discount**: For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
- **Tools Discount**: If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
- **Extensible**: Easily add new discount strategies.

## Requirements

- PHP 7.3 or higher
- Composer
- Slim 4 framework

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/floringit/teamleader.git
   cd teamleader
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Set up the local development server:

   ```bash
   php -S localhost:8080 -t public
   ```

## Usage

The application exposes an endpoint to apply discounts to a order. Here is an example of how to use it:

### Endpoint

`GET /discount`

### Request Body

```json
{
   "id": "3",
   "customer-id": "3",
   "items": [
      {
         "product-id": "A101",
         "quantity": "2",
         "unit-price": "9.75",
         "total": "19.50"
      },
      {
         "product-id": "A102",
         "quantity": "1",
         "unit-price": "49.50",
         "total": "49.50"
      }
   ],
   "total": "69.00"
}
```

### Response

```json
[
  {
    "amount":16.86,
    "reason":"TOTAL_REVENUE"
  },
  {
    "amount":9.98,
    "reason":"SWITCHES"
  },
  {
    "amount":1.95,
    "reason":"TOOLS"
  }
]
```

## Liveness check

`GET /status`

### Response

```json
{
  "api":"teamleader-discounts",
  "version":"1.0.0",
  "status":{
    "database":"OK"
  }
}
```

## Running Tests

This project uses PHPUnit for testing. To run the tests, execute the following command:

```bash
composer test
```