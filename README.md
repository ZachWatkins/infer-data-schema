# Infer Data Schema

This is a PHP library which infers the SQL column schema of a data source.

It reads a given data source, evaluates all values of all columns for the safest possible SQL column type and modifiers (unique, nullable, signed or unsigned, auto-incrementing), and generates a corresponding SqlColumnCollection object.

## Folder structure

1. `src/` - Contains the main PHP source code.  
   - `src/Interfaces` - Contains the interface definitions for the library's class files.  
   - `src/Enums` - Contains the enum definitions for the library.  
     - `src/Enums/DatabaseType.php` - The enum definition for supported database types.
     - `src/Enums/ColumnModifier.php` - The enum definition for SQL column modifiers (unique, nullable, signed or unsigned, auto-incrementing).
     - `src/Enums/SqliteColumnType.php` - The enum definition for SQLite column types.  
     - `src/Enums/MySqlColumnType.php` - The enum definition for MySQL column types.  
     - `src/Enums/SqlServerColumnType.php` - The enum definition for SQL Server column types.  
   - `src/Parsers` - Contains the data source parser classes for the library.  
     - `src/Parsers/CsvParser` - The CSV data source parser class.  
     - `src/Parsers/JsonParser` - The JSON data source parser class.  
     - `src/Parsers/XmlParser` - The XML data source parser class.  
     - `src/Parsers/ExcelParser` - The Excel data source parser class.  
     - `src/Parsers/HttpParser` - The HTTP data source parser class.  
   - `src/Models` - Contains the model classes for the library.
     - `src/Models/SqlColumn.php` - The model class representing a database column.  
     - `src/Models/SqlColumnCollection.php` - The model class representing a collection of database columns.  
   - `src/Console` - Contains the console command class for the library.  
2. `tests/` - Contains the test cases for the library.
3. `README.md` - This file, containing an overview and documentation for the library.
4. `composer.json` - The Composer configuration file for managing dependencies and autoloading.

## Dependencies

This library uses the following dependencies:

- `php` - The PHP programming language, required to run the library.
- `php-phar` - PHP phar extension for creating and running PHP archive (PHAR) files, required for packaging the library into a CLI binary application.
- `phpacker/phpacker` - The PHPacker library, required for packing the library into a CLI binary application.
- `flow-php/etl` - The Flow PHP ETL library, required for data extraction, transformation, and loading operations.
- `flow-php/etl-adapter-csv` - The Flow PHP ETL CSV adapter, required for parsing CSV data sources.
- `flow-php/etl-adapter-json` - The Flow PHP ETL JSON adapter, required for parsing JSON data sources.
- `flow-php/etl-adapter-xml` - The Flow PHP ETL XML adapter, required for parsing XML data sources.
- `flow-php/etl-adapter-excel` - The Flow PHP ETL Excel adapter, required for parsing Excel data sources.
- `flow-php/etl-adapter-http` - The Flow PHP ETL HTTP adapter, required for parsing HTTP data sources.

## Dependency Documentation Websites

- [PHP](https://www.php.net/)
- [PHP Phar](https://www.php.net/manual/en/book.phar.php)
- [PHPacker](https://phpacker.dev/docs/getting-started/)
- [Flow PHP ETL](https://flow-php.com/documentation/quick-start/)
- [Flow PHP ETL CSV Adapter](https://flow-php.com/documentation/components/adapters/csv/)
- [Flow PHP ETL JSON Adapter](https://flow-php.com/documentation/components/adapters/json/)
- [Flow PHP ETL XML Adapter](https://flow-php.com/documentation/components/adapters/xml/)
- [Flow PHP ETL Excel Adapter](https://flow-php.com/documentation/components/adapters/excel/)
- [Flow PHP ETL HTTP Adapter](https://flow-php.com/documentation/components/adapters/http/)
