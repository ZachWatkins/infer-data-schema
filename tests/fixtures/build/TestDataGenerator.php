<?php

/**
 * Generates the test data set.
 */

namespace Tests\Fixtures\Build;

require_once __DIR__ . '../vendor/autoload.php';

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
        return [
            'negative_one' => -1,
            'zero' => 0,
            'one' => 1,
            'tinyint_unsigned_random' => $this->faker->numberBetween(0, 255),
            'tinyint_unsigned_max' => 255,
            'tinyint_unsigned_max_plus_one' => 256,
            'tinyint_signed_random' => $this->faker->numberBetween(-128, 127),
            'tinyint_signed_min' => -128,
            'tinyint_signed_min_minus_one' => -129,
            'tinyint_signed_max' => 127,
            'tinyint_signed_max_plus_one' => 128,
            'smallint_unsigned_random' => $this->faker->numberBetween(256, 65535),
            'smallint_unsigned_min' => 0,
            'smallint_unsigned_max' => 65535,
            'smallint_unsigned_max_plus_one' => 65536,
            'smallint_signed_random' => $this->faker->numberBetween(-32768, -129),
            'smallint_signed_min' => -32768,
            'smallint_signed_min_minus_one' => -32769,
            'smallint_signed_max' => 32767,
            'smallint_signed_max_plus_one' => 32768,
        ];
    }

    protected function generateBitColumn(int $length): array
    {
        $values = array_fill(0, $length, 0);
        $values[0] = 1;
        return $values;
    }

    protected function generateTinyIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            return $this->generateNumericColumn($length, 0, 255, $nullable, $unique);
        }
        return $this->generateNumericColumn($length, -128, 127, $nullable, $unique);
    }

    protected function generateSmallIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            return $this->generateNumericColumn($length, 0, 65535, $nullable, $unique);
        }
        return $this->generateNumericColumn($length, -32768, 32767, $nullable, $unique);
    }

    protected function generateMediumIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            return $this->generateNumericColumn($length, 0, 16777215, $nullable, $unique);
        }
        return $this->generateNumericColumn($length, -8388608, 8388607, $nullable, $unique);
    }

    protected function generateIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            return $this->generateNumericColumn($length, 0, 4294967295, $nullable, $unique);
        }
        return $this->generateNumericColumn($length, -2147483648, 2147483647, $nullable, $unique);
    }

    protected function generateBigIntColumn(int $length, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        if ($unsigned) {
            return $this->generateNumericColumn($length, 0, 18446744073709551615, $nullable, $unique);
        }
        return $this->generateNumericColumn($length, -9223372036854775808, 9223372036854775807, $nullable, $unique);
    }

    protected function generateNumericColumn(int $length, int $min, int $max, bool $nullable = false, bool $unique = false): array
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

    protected function generateDecimalColumn(int $length, int $precision, bool $unsigned = false, bool $nullable = false, bool $unique = false): array
    {
        $values = [];
        $max = $unsigned ? pow(10, $length - $precision) - pow(10, -$precision) : pow(10, $length - $precision - 1) - pow(10, -$precision);
        $min = $unsigned ? 0 : -$max;
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
