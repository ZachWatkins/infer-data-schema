# Infer Data Schema

**This is not intended to be used in production environments. It is only intended for development and testing purposes.**

[![Test](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/test.yml/badge.svg)](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/test.yml) [![Audit](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/audit.yml/badge.svg)](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/audit.yml)

This PHP library performs limited inference of the SQL column schema for a given data source and can either provide those details or a [Laravel Shift Blueprint](https://blueprint.laravelshift.com/) YAML file, which can then be used to scaffold the relevant [Laravel](https://laravel.com/) PHP framework files which implement that data model into an existing application.

## Example usage

```php

use ZachWatkins\InferDataSchema\SQL\Parsers\CsvParser;

$parser = new CsvParser();
$sqlColumnCollection = $parser->parse('path/to/your/file.csv');
var_dump($sqlColumnCollection);
// SQLColumnCollection Object
// (
//     [columns:protected] => Array
//         (
//             [0] => SQLColumn Object
//                 (
//                     [name:protected] => id
//                     [type:protected] => int
//                     [modifiers:protected] => Array
//                         (
//                             [0] => auto_increment
//                             [1] => unsigned
//                             [2] => unique
//                         )
//                 )
//             [1] => SQLColumn Object
//                 (
//                     [name:protected] => name
//                     [type:protected] => varchar
//                     [modifiers:protected] => Array
//                         (
//                             [0] => nullable
//                         )
//                 )
//         )
// )
foreach ($sqlColumnCollection->getColumns() as $column) {
    echo $column->getName() . ': ' . $column->getType() . ' ' . implode(', ', $column->getModifiers()) . PHP_EOL;
}
```

## Running from the CLI

When running from a source checkout, pass a supported data file to `index.php`. SQL schema details are printed to the console:

```sh
php index.php --db=mysql path/to/users.csv
```

The CLI supports CSV, JSON, XML, and Excel files (`.xlsx`, `.xls`, and `.ods`). Select Laravel Shift Blueprint output with `--format=blueprint`; set the model name as needed:

```sh
php index.php --format=blueprint --blueprint-model=User path/to/users.json
```

Blueprint YAML is printed to the console by default. Add `--save` to write it beside the input file instead. For example, this saves a YAML file based on the inferred model name:

```sh
php index.php --format=blueprint --blueprint-model=User --save path/to/users.csv
```

To see all available options, run:

```sh
php index.php --help
```

## Dependencies

This library uses the following dependencies:

- `php` - The PHP programming language, required to run the library.
- `flow-php/etl` - The Flow PHP ETL library, required for data extraction, transformation, and loading operations.
- `flow-php/etl-adapter-csv` - The Flow PHP ETL CSV adapter, required for parsing CSV data sources.
- `flow-php/etl-adapter-json` - The Flow PHP ETL JSON adapter, required for parsing JSON data sources.
- `flow-php/etl-adapter-xml` - The Flow PHP ETL XML adapter, required for parsing XML data sources.
- `flow-php/etl-adapter-excel` - The Flow PHP ETL Excel adapter, required for parsing Excel data sources.
- `flow-php/etl-adapter-http` - The Flow PHP ETL HTTP adapter, required for parsing HTTP data sources.
- `pestphp/pest` - The Pest PHP testing framework, required for running the test cases.

## Development

To build the test fixtures after making changes to the library, run the following command:

```sh
composer test:build
```

To build the library as a standalone executable CLI application, run the following command:

```sh
composer build
```

To install the standalone executable CLI application as a system-wide GitHub Copilot agent skill, run the following command:

```sh
composer install:skill
```

If you use a different coding agent, you can run these commands replacing "path" with the folder you want to install the skill to:

```sh
composer build
php scripts/install-skill.php --destination={path}
```

## Additional Resources

- [PHP](https://www.php.net/)
- [Flow PHP ETL](https://flow-php.com/documentation/quick-start/)
- [Flow PHP ETL CSV Adapter](https://flow-php.com/documentation/components/adapters/csv/)
- [Flow PHP ETL JSON Adapter](https://flow-php.com/documentation/components/adapters/json/)
- [Flow PHP ETL XML Adapter](https://flow-php.com/documentation/components/adapters/xml/)
- [Flow PHP ETL Excel Adapter](https://flow-php.com/documentation/components/adapters/excel/)
- [Flow PHP ETL HTTP Adapter](https://flow-php.com/documentation/components/adapters/http/)
- [Pest PHP](https://pestphp.com/docs/introduction)
- [SQL Server Data Types](https://learn.microsoft.com/en-us/sql/t-sql/data-types/data-types-transact-sql)
