# Infer Data Schema

**This is not intended to be used in production environments. It is only intended for development and testing purposes.**

[![Test](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/test.yml/badge.svg)](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/test.yml) [![Audit](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/audit.yml/badge.svg)](https://github.com/ZachWatkins/infer-data-schema/actions/workflows/audit.yml)

This PHP library infers the SQL column schema of a data source and can either provide those details or use them to generate a Laravel Shift Blueprint YAML file, which can then be used to scaffold the corresponding Laravel files to implement that data model into an existing application.

It reads a given data source, evaluates all values of all columns for the safest possible SQL column type and modifiers (unique, nullable, signed or unsigned, auto-incrementing), and generates a corresponding SQLColumnCollection object.

## Folder structure

1. `.github/` - Contains GitHub-specific configuration files, such as workflows for CI/CD.  
   - `workflows/` - Contains the GitHub Actions workflow files for CI/CD.  
   - `workflows/lint.yml` - The GitHub Actions workflow file for running code style checks.  
   - `workflows/build.yml` - The GitHub Actions workflow file for building and running the binary using a list of PHP versions.  
   - `workflows/test.yml` - The GitHub Actions workflow file for running tests using a list of PHP versions.  
2. `documentation/` - Contains the documentation files for the library, including ADRs and other relevant documentation.
   - `documentation/adrs/` - Contains the Architecture Decision Records (ADRs) for the library.
3. `src/` - Contains the main PHP source code.  
   - `src/SQL/` - Contains the main SQL-related source code for the library.
     - `src/SQL/Interfaces` - Contains the interface definitions for the library's class files.  
     - `src/SQL/Enums` - Contains the SQL enum definitions for the library.  
       - `src/SQL/Enums/DatabaseType.php` - The enum definition for supported database types.  
       - `src/SQL/Enums/ColumnModifier.php` - The enum definition for SQL column modifiers (unique, nullable, signed or unsigned, auto-incrementing).  
       - `src/SQL/Enums/SQLiteColumnType.php` - The enum definition for SQLite column types.  
       - `src/SQL/Enums/MySQLColumnType.php` - The enum definition for MySQL column types.  
       - `src/SQL/Enums/SQLServerColumnType.php` - The enum definition for SQL Server column types.  
     - `src/SQL/Parsers` - Contains the data source parser classes for the SQL inference library features.  
       - `src/SQL/Parsers/CsvParser.php` - The CSV data source parser class.  
       - `src/SQL/Parsers/JsonParser.php` - The JSON data source parser class.  
       - `src/SQL/Parsers/XmlParser.php` - The XML data source parser class.  
       - `src/SQL/Parsers/ExcelParser.php` - The Excel data source parser class.  
       - `src/SQL/Parsers/HttpParser.php` - The HTTP data source parser class.  
     - `src/SQL/Models` - Contains the model classes for the library.  
       - `src/SQL/Models/SQLColumn.php` - The model class representing a database column.  
       - `src/SQL/Models/SQLColumnCollection.php` - The model class representing a collection of database columns.  
   - `src/Console.php` - The console class for the library.  
3. `tests/` - Contains the test cases for the library.  
   - `tests/fixtures/` - Contains test fixture files used for testing the library's parsers and schema inference logic.  
   - `tests/fixtures/data/` - Contains the actual data files used as test fixtures for the library's parsers and schema inference logic.
   - `tests/fixtures/schema/` - Contains the expected schema objects corresponding to the data files, used for validating the library's schema inference logic.
   - `tests/Features/` - Contains the feature test cases for the library, typically testing the integration of parsers and schema inference logic.
4. `AGENTS.md` - The file containing information for coding agents when generating code for the library.
5. `composer.json` - The Composer configuration file for managing dependencies and autoloading.
6. `README.md` - The readme file, containing an overview and documentation for the library.

## Example usage

```php
require 'vendor/autoload.php';

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
