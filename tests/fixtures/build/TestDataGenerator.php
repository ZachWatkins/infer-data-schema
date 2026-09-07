<?php

/**
 * Generates the test data set.
 */

namespace Tests\Fixtures\Build;

class TestDataGenerator
{
    protected \Faker\Generator $faker;
    public function __construct(
        ?\Faker\Generator $faker = null
    ) {
        $this->faker = $faker ?? \Faker\Factory::create();
    }

    /**
     * The test data will include values that represent all possible combinations of database column types and column modifiers supported by this library. Example: tinyint, varchar, text, boolean, date, datetime, json, xml, char, unsigned decimal, nullable date, incrementing bigint, unique char, etc.
     */
    public function generate(int $length = 10): array
    {
        $columns = [
            'bit' => $this->generateBitColumn($length),
            'bit_nullable' => $this->generateBitColumn($length, nullable: true),
            'tinyint' => $this->generateTinyIntColumn($length),
            'tinyint_nullable' => $this->generateTinyIntColumn($length, nullable: true),
            'tinyint_unique' => $this->generateTinyIntColumn($length, unique: true),
            'tinyint_nullable_unique' => $this->generateTinyIntColumn($length, nullable: true, unique: true),
            'tinyint_unsigned' => $this->generateTinyIntColumn($length, unsigned: true),
            'tinyint_unsigned_nullable' => $this->generateTinyIntColumn($length, unsigned: true, nullable: true),
            'tinyint_unsigned_unique' => $this->generateTinyIntColumn($length, unsigned: true, unique: true),
            'tinyint_unsigned_nullable_unique' => $this->generateTinyIntColumn($length, unsigned: true, nullable: true, unique: true),
            'smallint' => $this->generateSmallIntColumn($length),
            'smallint_nullable' => $this->generateSmallIntColumn($length, nullable: true),
            'smallint_unique' => $this->generateSmallIntColumn($length, unique: true),
            'smallint_nullable_unique' => $this->generateSmallIntColumn($length, nullable: true, unique: true),
            'smallint_unsigned' => $this->generateSmallIntColumn($length, unsigned: true),
            'smallint_unsigned_nullable' => $this->generateSmallIntColumn($length, unsigned: true, nullable: true),
            'smallint_unsigned_unique' => $this->generateSmallIntColumn($length, unsigned: true, unique: true),
            'smallint_unsigned_nullable_unique' => $this->generateSmallIntColumn($length, unsigned: true, nullable: true, unique: true),
            'mediumint' => $this->generateMediumIntColumn($length),
            'mediumint_nullable' => $this->generateMediumIntColumn($length, nullable: true),
            'mediumint_unique' => $this->generateMediumIntColumn($length, unique: true),
            'mediumint_nullable_unique' => $this->generateMediumIntColumn($length, nullable: true, unique: true),
            'mediumint_unsigned' => $this->generateMediumIntColumn($length, unsigned: true),
            'mediumint_unsigned_nullable' => $this->generateMediumIntColumn($length, unsigned: true, nullable: true),
            'mediumint_unsigned_unique' => $this->generateMediumIntColumn($length, unsigned: true, unique: true),
            'mediumint_unsigned_nullable_unique' => $this->generateMediumIntColumn($length, unsigned: true, nullable: true, unique: true),
            'int' => $this->generateIntColumn($length),
            'int_nullable' => $this->generateIntColumn($length, nullable: true),
            'int_unique' => $this->generateIntColumn($length, unique: true),
            'int_nullable_unique' => $this->generateIntColumn($length, nullable: true, unique: true),
            'int_unsigned' => $this->generateIntColumn($length, unsigned: true),
            'int_unsigned_nullable' => $this->generateIntColumn($length, unsigned: true, nullable: true),
            'int_unsigned_unique' => $this->generateIntColumn($length, unsigned: true, unique: true),
            'int_unsigned_nullable_unique' => $this->generateIntColumn($length, unsigned: true, nullable: true, unique: true),
            'bigint' => $this->generateBigIntColumn($length),
            'bigint_nullable' => $this->generateBigIntColumn($length, nullable: true),
            'bigint_unique' => $this->generateBigIntColumn($length, unique: true),
            'bigint_nullable_unique' => $this->generateBigIntColumn($length, nullable: true, unique: true),
            'bigint_unsigned' => $this->generateBigIntColumn($length, unsigned: true),
            'bigint_unsigned_nullable' => $this->generateBigIntColumn($length, unsigned: true, nullable: true),
            'bigint_unsigned_unique' => $this->generateBigIntColumn($length, unsigned: true, unique: true),
            'bigint_unsigned_nullable_unique' => $this->generateBigIntColumn($length, unsigned: true, nullable: true, unique: true),
            'decimal' => $this->generateDecimalColumn($length),
            'decimal_nullable' => $this->generateDecimalColumn($length, nullable: true),
            'decimal_unique' => $this->generateDecimalColumn($length, unique: true),
            'decimal_nullable_unique' => $this->generateDecimalColumn($length, nullable: true, unique: true),
            'decimal_unsigned' => $this->generateDecimalColumn($length, unsigned: true),
            'decimal_unsigned_nullable' => $this->generateDecimalColumn($length, unsigned: true, nullable: true),
            'decimal_unsigned_unique' => $this->generateDecimalColumn($length, unsigned: true, unique: true),
            'decimal_unsigned_nullable_unique' => $this->generateDecimalColumn($length, unsigned: true, nullable: true, unique: true),
            'boolean' => $this->generateBooleanColumn($length),
            'boolean_nullable' => $this->generateBooleanColumn($length, nullable: true),
            'boolean_unique' => $this->generateBooleanColumn($length, unique: true),
            'boolean_nullable_unique' => $this->generateBooleanColumn($length, nullable: true, unique: true),
            'char' => $this->generateCharColumn($length, 2),
            'char_nullable' => $this->generateCharColumn($length, 2, nullable: true),
            'char_unique' => $this->generateCharColumn($length, 2, unique: true),
            'char_nullable_unique' => $this->generateCharColumn($length, 2, nullable: true, unique: true),
            'varchar' => $this->generateVarcharColumn($length, 255),
            'varchar_nullable' => $this->generateVarcharColumn($length, 255, nullable: true),
            'varchar_unique' => $this->generateVarcharColumn($length, 255, unique: true),
            'varchar_nullable_unique' => $this->generateVarcharColumn($length, 255, nullable: true, unique: true),
            'text' => $this->generateTextColumn($length),
            'text_nullable' => $this->generateTextColumn($length, nullable: true),
            'text_unique' => $this->generateTextColumn($length, unique: true),
            'text_nullable_unique' => $this->generateTextColumn($length, nullable: true, unique: true),
            'date' => $this->generateDateColumn($length),
            'date_nullable' => $this->generateDateColumn($length, nullable: true),
            'date_unique' => $this->generateDateColumn($length, unique: true),
            'date_nullable_unique' => $this->generateDateColumn($length, nullable: true, unique: true),
            'time' => $this->generateTimeColumn($length),
            'time_nullable' => $this->generateTimeColumn($length, nullable: true),
            'time_unique' => $this->generateTimeColumn($length, unique: true),
            'time_nullable_unique' => $this->generateTimeColumn($length, nullable: true, unique: true),
            'datetime' => $this->generateDateTimeColumn($length),
            'datetime_nullable' => $this->generateDateTimeColumn($length, nullable: true),
            'datetime_unique' => $this->generateDateTimeColumn($length, unique: true),
            'datetime_nullable_unique' => $this->generateDateTimeColumn($length, nullable: true, unique: true),
            'json' => $this->generateJsonColumn($length),
            'json_nullable' => $this->generateJsonColumn($length, nullable: true),
            'json_unique' => $this->generateJsonColumn($length, unique: true),
            'json_nullable_unique' => $this->generateJsonColumn($length, nullable: true, unique: true),
            'xml' => $this->generateXmlColumn($length),
            'xml_nullable' => $this->generateXmlColumn($length, nullable: true),
            'xml_unique' => $this->generateXmlColumn($length, unique: true),
            'xml_nullable_unique' => $this->generateXmlColumn($length, nullable: true, unique: true),
        ];
        $values = [];
        for ($i = 0; $i < $length; $i++) {
            $values[$i] = [];
            foreach ($columns as $columnName => $columnValues) {
                $values[$i][$columnName] = $columnValues[$i];
            }
        }
        return $values;
    }

    protected function generateBitColumn(int $length, bool $nullable = false): array
    {
        $values = array_fill(0, $length, 0);
        $values[0] = 1;
        if ($nullable) {
            if ($length > 1) {
                $values[1] = null;
            } else {
                $values[0] = null;
            }
        }
        return $values;
    }

    protected function generateTinyIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            $unsignedTinyIntMin = 0;
            $unsignedTinyIntMax = 255;
            return $this->generateNumericColumn($length, $unsignedTinyIntMin, $unsignedTinyIntMax, $nullable, $unique);
        }
        $signedTinyIntMin = -128;
        $signedTinyIntMax = 127;
        return $this->generateNumericColumn($length, $signedTinyIntMin, $signedTinyIntMax, $nullable, $unique);
    }

    protected function generateSmallIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            $unsignedSmallIntMin = 0;
            $unsignedSmallIntMax = 65535;
            return $this->generateNumericColumn($length, $unsignedSmallIntMin, $unsignedSmallIntMax, $nullable, $unique);
        }
        $signedSmallIntMin = -32768;
        $signedSmallIntMax = 32767;
        return $this->generateNumericColumn($length, $signedSmallIntMin, $signedSmallIntMax, $nullable, $unique);
    }

    protected function generateMediumIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            $unsignedMediumIntMin = 0;
            $unsignedMediumIntMax = 16777215;
            return $this->generateNumericColumn($length, $unsignedMediumIntMin, $unsignedMediumIntMax, $nullable, $unique);
        }
        $signedMediumIntMin = -8388608;
        $signedMediumIntMax = 8388607;
        return $this->generateNumericColumn($length, $signedMediumIntMin, $signedMediumIntMax, $nullable, $unique);
    }

    protected function generateIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            $unsignedIntMin = 0;
            $unsignedIntMax = 4294967295;
            return $this->generateNumericColumn($length, $unsignedIntMin, $unsignedIntMax, $nullable, $unique);
        }
        $signedIntMin = -2147483648;
        $signedIntMax = 2147483647;
        return $this->generateNumericColumn($length, $signedIntMin, $signedIntMax, $nullable, $unique);
    }

    protected function generateBigIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            $unsignedBigIntMin = 0;
            $unsignedBigIntMax = 18446744073709551615;
            return $this->generateNumericColumn($length, $unsignedBigIntMin, $unsignedBigIntMax, $nullable, $unique);
        }
        $signedBigIntMin = -9223372036854775808;
        $signedBigIntMax = 9223372036854775807;
        return $this->generateNumericColumn($length, $signedBigIntMin, $signedBigIntMax, $nullable, $unique);
    }

    protected function generateNumericColumn(int $length, $min, $max, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        $value = $max;
        for ($i = 0; $i < $length; $i++) {
            if ($value < $min) {
                throw new \OverflowException("Cannot generate a numeric value of {$value} for range [$min, $max].");
            }
            $values[] = $value--;
        }
        $nulledIndex = null;
        if ($nullable) {
            $nulledIndex = array_rand($values);
            $values[$nulledIndex] = null;
        }
        if (!$unique && $length > 1) {
            if (!$nulledIndex) {
                $values[0] = $values[1];
            } elseif ($length > 2) {
                if ($nulledIndex === 0) {
                    $values[1] = $values[2];
                } elseif ($nulledIndex === 1) {
                    $values[0] = $values[2];
                } else {
                    $values[0] = $values[1];
                }
            }
        }
        return $values;
    }

    protected function generateDecimalColumn(int $length, int $precision = 2, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        $max = $unsigned ? pow(10, $length - $precision) - pow(10, -$precision) : pow(10, $length - $precision - 1) - pow(10, -$precision);
        for ($i = 0; $i < $length; $i++) {
            $values[] = $max - $i * pow(10, -$precision);
        }
        $nulledIndex = null;
        if ($nullable) {
            $nulledIndex = array_rand($values);
            $values[$nulledIndex] = null;
        }
        if (!$unique && $length > 1) {
            if (!$nulledIndex) {
                $values[0] = $values[1];
            } elseif ($length > 2) {
                if ($nulledIndex === 0) {
                    $values[1] = $values[2];
                } elseif ($nulledIndex === 1) {
                    $values[0] = $values[2];
                } else {
                    $values[0] = $values[1];
                }
            }
        }
        return $values;
    }

    protected function generateBooleanColumn(int $length, bool $nullable = false, bool $unique = false): array
    {
        $values = array_fill(0, $length, true);
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }

    protected function generateCharColumn(int $length, int $charLength = 2, bool $nullable = false, bool $unique = false): array
    {
        $charColumnMinLength = 0;
        $charColumnMaxLength = 255;
        if ($charLength < $charColumnMinLength || $charLength > $charColumnMaxLength) {
            throw new \InvalidArgumentException('CHAR length must be between ' . $charColumnMinLength . ' and ' . $charColumnMaxLength . '.');
        }
        return $this->generateStringColumn($length, $charLength, $charLength, $nullable, $unique);
    }

    protected function generateVarcharColumn(int $length, int $varcharLength = 256, bool $nullable = false, bool $unique = false): array
    {
        $varcharColumnMinLength = 0;
        $varcharColumnMaxLength = 65535;

        if ($varcharLength < $varcharColumnMinLength || $varcharLength > $varcharColumnMaxLength) {
            throw new \InvalidArgumentException('VARCHAR length must be between ' . $varcharColumnMinLength . ' and ' . $varcharColumnMaxLength . '.');
        }
        return $this->generateStringColumn($length, 0, $varcharLength, $nullable, $unique);
    }

    protected function generateStringColumn(int $length, int $minStrLength, int $maxStrLength, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        $seed = str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $maxStrLength);
        for ($i = 0; $i < $length; $i++) {
            $strLength = rand($minStrLength, $maxStrLength);
            $values[] = substr(str_shuffle($seed), 0, $strLength);
        }
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }

    protected function generateTextColumn(int $length, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        // This is the number of characters for a MySQL text column that surpasses the limit of a VARCHAR column (65535) and therefore requires a TEXT column.
        $textLengthThreshold = 65536;
        $sample = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $repeatLength = ceil($textLengthThreshold / strlen($sample));
        $seed = substr(str_repeat($sample, $repeatLength), 0, $textLengthThreshold);
        for ($i = 0; $i < $length; $i++) {
            $values[] = str_shuffle($seed);
        }
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }

    protected function generateDateColumn(int $length, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        for ($i = 0; $i < $length; $i++) {
            $values[] = date('Y-m-d', strtotime("-$i days"));
        }
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }

    protected function generateTimeColumn(int $length, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        for ($i = 0; $i < $length; $i++) {
            $values[] = date('H:i:s', strtotime("-$i seconds"));
        }
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }

    protected function generateDateTimeColumn(int $length, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        for ($i = 0; $i < $length; $i++) {
            $values[] = date('Y-m-d H:i:s', strtotime("-$i days"));
        }
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }

    protected function generateJsonColumn(int $length, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        for ($i = 0; $i < $length; $i++) {
            $values[] = json_encode(['key' => "value$i"]);
        }
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }

    protected function generateXmlColumn(int $length, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        for ($i = 0; $i < $length; $i++) {
            $values[] = "<root><key>value$i</key></root>";
        }
        if ($nullable) {
            $values[0] = null;
            if (!$unique && $length > 2) {
                $values[1] = $values[2];
            }
        } elseif (!$unique && $length > 1) {
            $values[0] = $values[1];
        }
        return $values;
    }
}
