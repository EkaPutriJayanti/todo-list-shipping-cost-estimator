<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShippingFeatureTest extends TestCase
{
    /**
     * Test jika semua field kosong (validasi wajib).
     */
    public function test_form_validation_errors()
    {
        $response = $this->post(route('shipping.calculate'), []);
        $response->assertSessionHasErrors(['weight', 'distance', 'service']);
    }

    /**
     * Test jika berat dan jarak bernilai negatif (tidak boleh).
     */
    public function test_negative_input_validation()
    {
        $response = $this->post(route('shipping.calculate'), [
            'weight' => -2,
            'distance' => -10,
            'service' => 'regular',
        ]);

        $response->assertSessionHasErrors(['weight', 'distance']);
    }

    /**
     * Test jika nilai nol digunakan (valid dan dihitung).
     */
    public function test_zero_input_should_pass()
    {
        $response = $this->post(route('shipping.calculate'), [
            'weight' => 0,
            'distance' => 0,
            'service' => 'regular',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('cost');
        $this->assertEquals(0, session('cost'));
    }

    /**
     * Test layanan shipping reguler dengan input valid.
     */
    public function test_regular_shipping_cost()
    {
        $response = $this->post(route('shipping.calculate'), [
            'weight' => 2,
            'distance' => 10,
            'service' => 'regular',
        ]);

        $expected = (2 * 5000) + (10 * 2000); // 10000 + 20000 = 30000

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('cost');
        $this->assertEquals($expected, session('cost'));
    }

    /**
     * Test layanan shipping express dengan input valid.
     */
    public function test_express_shipping_cost()
    {
        $response = $this->post(route('shipping.calculate'), [
            'weight' => 1,
            'distance' => 5,
            'service' => 'express',
        ]);

        $expected = (1 * 5000) + (5 * 2000) + 10000; // 5000 + 10000 + 10000 = 25000

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('cost');
        $this->assertEquals($expected, session('cost'));
    }

    /**
     * Test jika service yang diberikan tidak valid.
     */
    public function test_invalid_service_type()
    {
        $response = $this->post(route('shipping.calculate'), [
            'weight' => 1,
            'distance' => 5,
            'service' => 'superfast', // invalid
        ]);

        $response->assertSessionHasErrors(['service']);
    }

    /**
     * Test jika input berupa string (bukan angka).
     */
    public function test_string_input_should_fail()
    {
        $response = $this->post(route('shipping.calculate'), [
            'weight' => 'abc',
            'distance' => 'xyz',
            'service' => 'regular',
        ]);

        $response->assertSessionHasErrors(['weight', 'distance']);
    }
}
