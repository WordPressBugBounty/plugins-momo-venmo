<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( 'no' === $this->enabled ) {
    return;
}
if ( is_checkout() ) {
    wp_register_style( 'wc_venmo_checkout', WCVENMO_PLUGIN_DIR_URL . 'assets/css/checkout.css' );
    wp_enqueue_style( 'wc_venmo_checkout' );
    $copy_js = 'copy.js';
    if ( !wp_script_is( $copy_js, 'enqueued' ) ) {
        wp_register_script(
            $copy_js,
            WCVENMO_PLUGIN_DIR_URL . 'assets/js/' . $copy_js,
            array('jquery', 'wc_venmo_qrcode'),
            null,
            true
        );
        wp_enqueue_script( $copy_js );
        // wp_enqueue_script( 'wc_venmo_copy', WCVENMO_PLUGIN_DIR_URL . 'assets/js/copy.js' );
    }
    $qrcode_styling = 'qr-code-styling.min.js';
    if ( !wp_script_is( $qrcode_styling, 'enqueued' ) ) {
        wp_register_script( $qrcode_styling, WCVENMO_PLUGIN_DIR_URL . 'assets/js/' . $qrcode_styling );
        wp_enqueue_script( $qrcode_styling );
        // wp_enqueue_script( 'wc_venmo_qrcode_styling', WCVENMO_PLUGIN_DIR_URL . 'assets/js/qr-code-styling.min.js' );
    }
    $qrcode_generator = 'qr-code-generator.js';
    if ( !wp_script_is( $qrcode_generator, 'enqueued' ) ) {
        wp_register_script( $qrcode_generator, WCVENMO_PLUGIN_DIR_URL . 'assets/js/' . $qrcode_generator );
        wp_enqueue_script( $qrcode_generator );
        // wp_enqueue_script( 'wc_venmo_qrcode_generator', WCVENMO_PLUGIN_DIR_URL . 'assets/js/qr-code-generator.js' );
    }
    wp_enqueue_script(
        'wc_venmo_qrcode',
        WCVENMO_PLUGIN_DIR_URL . 'assets/js/qrcode.js',
        array('jquery', $qrcode_styling, $qrcode_generator),
        null,
        true
    );
    global $woocommerce;
    $amount = $woocommerce->cart->total;
    $domain = ( !empty( parse_url( get_bloginfo( 'url' ) ) ) ? parse_url( get_bloginfo( 'url' ) )['host'] : null );
    $venmo_note = ( !empty( $this->venmo_note ) ? esc_html__( $this->venmo_note, WCVENMO_PLUGIN_TEXT_DOMAIN ) : sprintf( esc_html__( 'Test Order from %s', WCVENMO_PLUGIN_TEXT_DOMAIN ), $domain ) );
    // $payment_url = 'https://venmo.com/' . esc_attr( wp_kses_post( $this->ReceiverVenmo )) . "?txn=pay&amount=" . $amount . "&note=" . urlencode(esc_attr(wp_kses_post( $venmo_note )));
    $payment_url = $this->wc_venmo_payment_url( 1, $venmo_note );
    $wc_venmo_qrcode = array(
        "url" => $payment_url,
    );
    $wc_venmo_qrcode['logo'] = '';
    $wc_venmo_qrcode['width'] = 150;
    $wc_venmo_qrcode['height'] = 150;
    $wc_venmo_qrcode['darkcolor'] = '#000000';
    $wc_venmo_qrcode['lightcolor'] = '#ffffff';
    $wc_venmo_qrcode['backgroundcolor'] = '#ffffff';
    $wc_venmo_qrcode['dotsType'] = 'dots';
    $wc_venmo_qrcode['cornersSquareType'] = 'extra-rounded';
    $wc_venmo_qrcode['cornersDotType'] = 'square';
    wp_localize_script( 'wc_venmo_qrcode', 'wc_venmo_qrcode', $wc_venmo_qrcode );
    // // jquery-dialog on checkout/thankyou with countdown https://jqueryui.com/demos/dialog/
    // wp_enqueue_script( 'jquery-ui-dialog' );
}
// if ( ! is_cart() || ! is_checkout() || ! isset( $_GET['pay_for_order'] ) ) { }