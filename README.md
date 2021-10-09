# Non Profile Charity Search

Search non profitable organization or get the details of an organization

## Installation

Require the package using composer:

```bash
composer require touhidurabir/non-profit-charity-search
```

## Usage

```php
use Touhidurabir\NonProfitCharitySearch\CharitySearch;

$search = new CharitySearch('search-query', []);

$search = $search->charities()->getResult();
```

> NOTE : the README is incomplete . need to document the full functionality properly yet .

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](./LICENSE.md)
