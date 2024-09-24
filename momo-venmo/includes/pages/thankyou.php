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
$note = sprintf( esc_html__( 'Order %1s checkout at %2s', WCVENMO_PLUGIN_TEXT_DOMAIN ), $order_id, get_site_url() );
$payment_url = $this->wc_venmo_payment_url( $amount, $note );
$qr_code_url = $this->wc_venmo_qrcode_url( $amount, $note );
$qr_code = $this->wc_venmo_qrcode_html( $amount, $note );
$thankyou_html .= '<div id="wc-' . esc_attr( $this->id ) . '-form" data-plugin="' . wp_kses_post( WCVENMO_PLUGIN_VERSION ) . '">';
$thankyou_html .= '<h2>' . esc_html__( 'Venmo Notice', WCVENMO_PLUGIN_TEXT_DOMAIN ) . '</h2>';
$thankyou_html .= '<p><strong style="font-size:large;">' . sprintf( esc_html__( 'Please use your Order Number: %s as the payment reference', WCVENMO_PLUGIN_TEXT_DOMAIN ), $order_id ) . '.</strong></p>';
// $default_qrcode = '<img width="150" height="150" class="logo-qr" alt="Venmo link" src="https://emailreceipts.io/qr?d=150&t=https://venmo.com/'. esc_attr( wp_kses_post( $this->ReceiverVenmo ) ) . "?txn=pay&amount=" . $amount . "&note=" . urlencode(esc_attr(wp_kses_post( $note ))) . '">';
// $thankyou_html .= '<p class="momo-venmo">' . esc_html__( 'Click', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' > ';
// $thankyou_html .= '<a class="paym_link" href="' . $payment_url . '" target="_blank"><img width="150" height="150" class="logo-qr" alt="Venmo link" src="' . esc_url( WCVENMO_PLUGIN_DIR_URL . 'assets/images/venmo.png' ) . '"></a>';
// $thankyou_html .= ' ' . esc_html__('or Scan', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' > <a class="paym_link" href="' . $payment_url . '" target="_blank">' . $default_qrcode . '</a></p>';
$thankyou_html .= $qr_code;
$thankyou_html .= '<p><strong>' . esc_html__( 'Disclaimer', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ': </strong>' . esc_html__( 'Your order will not be processed until funds have cleared in our Venmo account', WCVENMO_PLUGIN_TEXT_DOMAIN ) . '.</p>';
$thankyou_html .= '</div><br><hr><br>';
echo $thankyou_html;
// return $thankyou_html;