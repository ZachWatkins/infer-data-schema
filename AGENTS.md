# Agent Instructions for Infer Data Schema

This repository contains `infer-data-schema`, a PHP library that reads data sources (CSV, JSON, XML, Excel, HTTP) using Flow PHP ETL and infers SQL column types, modifiers, and schemas.

See [README.md](README.md) for full project details, usage examples, and dependency links.

## Language & Code Style

- **PHP Version**: Target PHP 8.3+.
- **Strict Types**: Always include `declare(strict_types=1);` at the top of every PHP file.
- **Code Standard**: Follow PSR-12 coding guidelines.
- **Type Safety**: Use explicit return types, parameter type hints, and typed properties for all methods and classes.
- **Enums**: Group column types and modifiers using backed enums (e.g. `SqliteColumnType`, `ColumnModifier`, `DatabaseType`).
- **Interfaces**: Define strict interface contracts under `src/Interfaces/` before implementing new parsers or models.

## Project Architecture

1. `.github/` - Contains GitHub-specific configuration files, such as workflows for CI/CD.  
   - `workflows/` - Contains the GitHub Actions workflow files for CI/CD.  
   - `workflows/lint.yml` - The GitHub Actions workflow file for running code style checks.  
   - `workflows/build.yml` - The GitHub Actions workflow file for building and running the binary using a list of PHP versions.  
   - `workflows/test.yml` - The GitHub Actions workflow file for running tests using a list of PHP versions.  
2. `documentation/` - Contains the documentation files for the library, including ADRs and other relevant documentation.
   - `documentation/adrs/` - Contains the Architecture Decision Records (ADRs) for the library.
3. `src/` - Contains the main PHP source code.  
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
   - `src/Console.php` - The console class for the library.  
3. `tests/` - Contains the test cases for the library.  
   - `tests/fixtures/` - Contains test fixture files used for testing the library's parsers and schema inference logic.  
   - `tests/fixtures/data/` - Contains the actual data files used as test fixtures for the library's parsers and schema inference logic.
   - `tests/fixtures/schema/` - Contains the expected schema objects corresponding to the data files, used for validating the library's schema inference logic.
   - `tests/Features/` - Contains the feature test cases for the library, typically testing the integration of parsers and schema inference logic.
4. `AGENTS.md` - The file containing information for coding agents when generating code for the library.
5. `composer.json` - The Composer configuration file for managing dependencies and autoloading.
6. `README.md` - The readme file, containing an overview and documentation for the library.

## Build & Test Commands

- **Install Dependencies**: `composer install`
- **Run Tests**: `composer run test`
- **Check Code Style**: `composer run lint`
- **Package CLI Binary**: `composer run build`

## Key Conventions

- **Parser Design**: Each parser in `src/Parsers/` must convert input datasets into an instance of `SqlColumnCollection`.
- **Modifier Detection**: Ensure column modifiers (`nullable`, `unique`, `unsigned`, `auto_increment`) are evaluated accurately across all rows in the dataset.
- **Testing**: Write Pest unit tests under `tests/` for all new parsers, models, and type inference logic using test datasets. Use test fixtures for data source files and the schema objects they are expected to produce.

## Coding Agents Guidance

When performing code changes that involve database-specific column type logic, use the official documentation by fetching the URL included in that column type's `@see` annotation to ensure accurate and up-to-date information about the data type.
