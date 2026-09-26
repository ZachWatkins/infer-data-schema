<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Enums;

/**
 * Laravel framework column types.
 *
 * @see https://laravel.com/docs/13.x/migrations#available-column-types
 */
enum LaravelColumnType: string
{
    /**
     * All non-null values across the column are drawn from a set of exactly two distinct values (e.g. 0/1, true/false, yes/no).
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-boolean
     */
    case boolean = 'boolean';
    /**
     * All values are strings whose byte length is identical (or padded) across every row, suiting a fixed-width code such as a currency or country abbreviation.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-char
     */
    case char = 'char';
    /**
     * Values are strings whose maximum observed length is very short (well under the TINYTEXT limit), suiting brief notes or single-word values.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-tinyText
     */
    case tinyText = 'tinyText';
    /**
     * Values are strings whose maximum observed length is short enough to fit a bounded VARCHAR (typically 255 characters or less), suiting names, labels, or codes.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-string
     */
    case string = 'string';
    /**
     * Values are free-form text whose maximum observed length exceeds a reasonable VARCHAR bound but stays within the TEXT limit, suiting descriptions or comments.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-text
     */
    case text = 'text';
    /**
     * Values are free-form text whose maximum observed length exceeds the TEXT limit but remains below the LONGTEXT range, indicating moderately large content bodies.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-mediumText
     */
    case mediumText = 'mediumText';
    /**
     * Values are free-form text whose maximum observed length exceeds the MEDIUMTEXT practical limit, indicating very large documents or content bodies.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-longText
     */
    case longText = 'longText';
    /**
     * Column is a unique, sequential, positive integer identifier that starts at one and increments by one for each row, indicating a primary key.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-bigIncrements
     */
    case bigIncrements = 'bigIncrements';
    /**
     * All values are whole numbers falling within a range that exceeds the standard INTEGER bounds, requiring 64-bit storage.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-bigInteger
     */
    case bigInteger = 'bigInteger';
    /**
     * All values are numeric with a consistent fixed number of digits after the decimal point across every row, indicating exact precision is required (e.g. monetary amounts).
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-decimal
     */
    case decimal = 'decimal';
    /**
     * All values are numeric with a variable or high number of digits after the decimal point, indicating floating-point precision is acceptable rather than exact decimal precision.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-double
     */
    case double = 'double';
    /**
     * All values are numeric with fractional components where a smaller floating-point precision is sufficient, such as sensor readings or approximate measurements.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-float
     */
    case float = 'float';
    /**
     * Column is a unique, sequential, positive integer identifier that fits within the standard INTEGER range, indicating a primary key on smaller datasets.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-increments
     */
    case increments = 'increments';
    /**
     * All values are whole numbers that fit within the standard signed INTEGER range without requiring 64-bit storage.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-integer
     */
    case integer = 'integer';
    /**
     * Column is a unique, sequential, positive integer identifier whose values fit within the MEDIUMINT range, indicating a primary key on a constrained dataset size.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-mediumIncrements
     */
    case mediumIncrements = 'mediumIncrements';
    /**
     * All values are whole numbers that fit within the MEDIUMINT range, smaller than a standard INTEGER but larger than a SMALLINT range.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-mediumInteger
     */
    case mediumInteger = 'mediumInteger';
    /**
     * Column is a unique, sequential, positive integer identifier whose values fit within the SMALLINT range, indicating a primary key on a small dataset.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-smallIncrements
     */
    case smallIncrements = 'smallIncrements';
    /**
     * All values are whole numbers that fit within the SMALLINT range, suiting small bounded counters or codes.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-smallInteger
     */
    case smallInteger = 'smallInteger';
    /**
     * Column is a unique, sequential, positive integer identifier whose values fit within the TINYINT range, indicating a primary key on a very small dataset.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-tinyIncrements
     */
    case tinyIncrements = 'tinyIncrements';
    /**
     * All values are whole numbers that fit within the TINYINT range, suiting flags, small enumerations, or narrow counters.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-tinyInteger
     */
    case tinyInteger = 'tinyInteger';
    /**
     * All values are whole numbers that are never negative and fall within the BIGINT range, indicating a foreign key or large unsigned count.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-unsignedBigInteger
     */
    case unsignedBigInteger = 'unsignedBigInteger';
    /**
     * All values are whole numbers that are never negative and fall within the standard INTEGER range.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-unsignedInteger
     */
    case unsignedInteger = 'unsignedInteger';
    /**
     * All values are whole numbers that are never negative and fall within the MEDIUMINT range.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-unsignedMediumInteger
     */
    case unsignedMediumInteger = 'unsignedMediumInteger';
    /**
     * All values are whole numbers that are never negative and fall within the SMALLINT range.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-unsignedSmallInteger
     */
    case unsignedSmallInteger = 'unsignedSmallInteger';
    /**
     * All values are whole numbers that are never negative and fall within the TINYINT range.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-unsignedTinyInteger
     */
    case unsignedTinyInteger = 'unsignedTinyInteger';
    /**
     * All values parse as a combined calendar date and time of day without timezone information, and include a fractional seconds component.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-dateTime
     */
    case dateTime = 'dateTime';
    /**
     * All values parse as a combined calendar date and time of day that includes an explicit timezone offset or designator.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-dateTimeTz
     */
    case dateTimeTz = 'dateTimeTz';
    /**
     * All values parse as a calendar date only, with no time-of-day component present in any row.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-date
     */
    case date = 'date';
    /**
     * All values parse as a time of day only, with no calendar date component present in any row.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-time
     */
    case time = 'time';
    /**
     * All values parse as a time of day only and include an explicit timezone offset or designator.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-timeTz
     */
    case timeTz = 'timeTz';
    /**
     * All values parse as a combined calendar date and time of day without timezone information, matching the pattern used for record creation or update tracking.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-timestamp
     */
    case timestamp = 'timestamp';
    /**
     * All values parse as a combined calendar date and time of day that includes an explicit timezone offset or designator, matching the pattern used for record creation or update tracking.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-timestampTz
     */
    case timestampTz = 'timestampTz';
    /**
     * All values are four-digit whole numbers falling within a plausible calendar year range.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-year
     */
    case year = 'year';
    /**
     * Values are binary data that does not decode as valid text under the dataset's declared character encoding.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-binary
     */
    case binary = 'binary';
    /**
     * All values parse as valid JSON (objects or arrays) when decoded, indicating structured, nested data.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-json
     */
    case json = 'json';
    /**
     * All values parse as valid JSON and the source database or format explicitly requests binary JSON storage for indexed querying.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-jsonb
     */
    case jsonb = 'jsonb';
    /**
     * All values match the 26-character Crockford base32 ULID format, indicating a lexicographically sortable unique identifier.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-ulid
     */
    case ulid = 'ulid';
    /**
     * All values match the canonical 36-character hyphenated UUID format, indicating a universally unique identifier.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-uuid
     */
    case uuid = 'uuid';
    /**
     * All values match a geographic coordinate or well-known text/binary spatial format intended for a geodetic (round-earth) reference system.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-geography
     */
    case geography = 'geography';
    /**
     * All values match a well-known text/binary spatial format intended for a planar (flat-earth) reference system.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-geometry
     */
    case geometry = 'geometry';
    /**
     * Column name follows the `{singular_table}_id` convention and its values are whole numbers matching identifiers found in another dataset's primary key column.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-foreignId
     */
    case foreignId = 'foreignId';
    /**
     * All non-null values across the column are drawn from a small, fixed set of repeated string labels, indicating a closed list of valid options.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-enum
     */
    case enum = 'enum';
    /**
     * Values contain a delimited combination of labels drawn from a small, fixed set of valid options, indicating multiple simultaneous selections are permitted per row.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-set
     */
    case set = 'set';
    /**
     * All values match the colon- or hyphen-separated hexadecimal octet format of a MAC address.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-macAddress
     */
    case macAddress = 'macAddress';
    /**
     * All values match a valid IPv4 dotted-decimal or IPv6 colon-hexadecimal address format.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-ipAddress
     */
    case ipAddress = 'ipAddress';
    /**
     * Column name matches `remember_token` and values are a random, fixed-length alphanumeric string, indicating an authentication "remember me" token.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-rememberToken
     */
    case rememberToken = 'rememberToken';
    /**
     * Values are a fixed-length array of floating-point numbers, indicating an embedding intended for similarity search.
     *
     * @see https://laravel.com/docs/13.x/migrations#column-method-vector
     *
     * @todo This is not yet implemented.
     */
    case vector = 'vector';
}
