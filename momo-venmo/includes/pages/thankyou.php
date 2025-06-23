<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$thankyou_html = '';
// $order = wc_get_order( $order_id );
$amount = $order->get_total();
$currency = $order->get_currency();
// $total = "$amount $currency";
// $total = $order->get_total();
$total = $order->get_formatted_order_total();
$note = sprintf( esc_html__( 'Order %1s checkout at %2s', 'momo-venmo' ), $order_id, get_site_url() );
$payment_url = $this->wc_venmo_payment_url( $amount, $note );
$qr_code_url = $this->wc_venmo_qrcode_url( $amount, $note );
$qr_code = $this->wc_venmo_qrcode_html( $amount, $note );
$thankyou_html .= '<div id="wc-' . esc_attr( $this->id ) . '-form" data-plugin="' . wp_kses_post( WCVENMO_PLUGIN_VERSION ) . '">';
$thankyou_html .= '<h2>' . esc_html__( 'Venmo Notice', 'momo-venmo' ) . '</h2>';
$thankyou_html .= '<p><strong style="font-size:large;">' . sprintf( esc_html__( 'Please use your Order Number: %s as the payment reference', 'momo-venmo' ), $order_id ) . '.</strong></p>';
$thankyou_html .= $qr_code;
$thankyou_html .= '<p><strong>' . esc_html__( 'Disclaimer', 'momo-venmo' ) . ': </strong>' . esc_html__( 'Your order will not be processed until funds have cleared in our Venmo account', 'momo-venmo' ) . '.</p>';
$thankyou_html .= '</div><br><hr><br>';
echo wp_kses_post($thankyou_html);
// return $thankyou_html;