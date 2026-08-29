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

- `.github/` - Contains GitHub-specific configuration files, such as workflows for CI/CD.
- `src/Interfaces/` - Interface definitions for parsers, schema builders, and models.
- `src/Enums/` - Enums for supported database types, SQL column types, and column modifiers.
- `src/Parsers/` - Data source parser implementations leveraging Flow PHP ETL adapters.
- `src/Models/` - Data models representing SQL columns (`SqlColumn`) and column collections (`SqlColumnCollection`).
- `src/Console.php` - CLI application entry point.
- `tests/` - Test suite written with Pest PHP.

## Build & Test Commands

- **Install Dependencies**: `composer install`
- **Run Tests**: `composer run test`
- **Check Code Style**: `composer run lint`
- **Package CLI Binary**: `composer run build`

## Key Conventions

- **Parser Design**: Each parser in `src/Parsers/` must convert input datasets into an instance of `SqlColumnCollection`.
- **Modifier Detection**: Ensure column modifiers (`nullable`, `unique`, `unsigned`, `auto_increment`) are evaluated accurately across all rows in the dataset.
- **Testing**: Write Pest unit tests under `tests/` for all new parsers, models, and type inference logic using test datasets. Use test fixtures for data source files and the schema objects they are expected to produce.
