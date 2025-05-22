<?php

namespace Tests\Unit;

use App\Helpers\ShippingHelper;
use PHPUnit\Framework\TestCase;

class ShippingHelperTest extends TestCase
{
    public function test_calculate_regular_shipping_cost()
    {
        $cost = ShippingHelper::calculateCost(2, 10, 'regular');
        $this->assertEquals(2 * 5000 + 10 * 2000, $cost);
    }

    public function test_calculate_express_shipping_cost()
    {
        $cost = ShippingHelper::calculateCost(3, 5, 'express');
        $this->assertEquals(3 * 5000 + 5 * 2000 + 10000, $cost);
    }

    public function test_calculate_express_shipping_cost_with_zero_weight()
    {
        $cost = ShippingHelper::calculateCost(0, 5, 'express');
        $this->assertEquals(0 * 5000 + 5 * 2000 + 10000, $cost);
    }

    public function test_calculate_zero_weight()
    {
        $cost = ShippingHelper::calculateCost(0, 10, 'regular');
        $this->assertEquals(0 * 5000 + 10 * 2000, $cost);
    }

    public function test_calculate_zero_distance()
    {
        $cost = ShippingHelper::calculateCost(2, 0, 'regular');
        $this->assertEquals(2 * 5000 + 0 * 2000, $cost);
    }

    public function test_calculate_negative_weight()
    {
        $this->expectException(\InvalidArgumentException::class);
        ShippingHelper::calculateCost(-1, 10, 'regular');
    }

    public function test_calculate_negative_distance()
    {
        $this->expectException(\InvalidArgumentException::class);
        ShippingHelper::calculateCost(2, -10, 'regular');
    }

    public function test_calculate_invalid_service()
    {
        $this->expectException(\InvalidArgumentException::class);
        ShippingHelper::calculateCost(2, 10, 'overnight');
    }
}
