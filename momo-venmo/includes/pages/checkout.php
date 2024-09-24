<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$checkout_html = '';
global $woocommerce;
$amount = $woocommerce->cart->total;
$total = $woocommerce->cart->get_total();
$note = sprintf( esc_html__( 'checkout at %s', WCVENMO_PLUGIN_TEXT_DOMAIN ), get_site_url() );
$payment_url = $this->wc_venmo_payment_url( $amount, $note );
$qr_code_url = $this->wc_venmo_qrcode_url( $amount, $note );
$qr_code = $this->wc_venmo_qrcode_html( $amount, $note );
$checkout_html .= '<fieldset id="wc-' . esc_attr( $this->id ) . '-form" data-plugin="' . wp_kses_post( WCVENMO_PLUGIN_VERSION ) . '">';
do_action( 'woocommerce_form_start', $this->id );
// upgrade display_venmo
if ( $this->display_venmo === 'no' ) {
    $this->update_option( 'display_venmo', '1' );
} else {
    if ( $this->display_venmo === 'yes' ) {
        $this->update_option( 'display_venmo', '2' );
    }
}
if ( empty( $this->ReceiverVenmo ) ) {
    $checkout_html .= '<p>' . wp_kses_post( __( 'Please finish setting up this payment method or contact the admin to do so.', WCVENMO_PLUGIN_TEXT_DOMAIN ) ) . '</p>';
    do_action( 'woocommerce_form_end', $this->id );
    $checkout_html .= '<input name="do_not_checkout" type="hidden" value="true"><div class="clear"></div></fieldset>';
    return;
}
$checkout_html .= '<p>' . esc_html__( 'Send', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' <a style="color: #3396cd" href="' . $payment_url . '" target="_blank">' . $total . " " . esc_html__( 'to', WCVENMO_PLUGIN_TEXT_DOMAIN ) . " " . esc_attr( wp_kses_post( $this->ReceiverVenmo ) ) . '</a> ' . esc_html__( 'or click/scan the Venmo button below', WCVENMO_PLUGIN_TEXT_DOMAIN ) . '</p>';
$checkout_html .= '<p>' . wp_kses_post( __( 'Please <strong style="font-size:large;">use your Order Number (available once you place order)</strong> as the payment reference', WCVENMO_PLUGIN_TEXT_DOMAIN ) ) . '.</p>';
// $checkout_html .= '<p class="momo-venmo">' . esc_html__('Click', WCVENMO_PLUGIN_TEXT_DOMAIN) . ' > ';
// $checkout_html .= '<a class="paym_link" href="' . $payment_url . '" target="_blank"><img width="150" height="150" class="logo-qr" alt="Venmo link" src="' , esc_url( WCVENMO_PLUGIN_DIR_URL . 'assets/images/venmo.png' ) , '"></a>';
// $checkout_html .= ' ' . esc_html__( 'or Scan', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' > <a class="paym_link" href="' . $payment_url . '" target="_blank"><img width="150" height="150" class="logo-qr" alt="Venmo link"
// src="https://emailreceipts.io/qr?d=100&t=https://venmo.com/', esc_attr( wp_kses_post( $this->ReceiverVenmo )) . "?txn=pay&amount=" . $amount . "&note=" . urlencode(esc_attr(wp_kses_post( $note ))) . '"></a></p>';
$checkout_html .= $qr_code;
$checkout_html .= '<p>' . wp_kses_post( __( '<strong>After paying, please come back here and place the order</strong> below so we can start processing your order', WCVENMO_PLUGIN_TEXT_DOMAIN ) ) . '.</p>';
// Support
$call = esc_html__( 'call', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' <a href="tel:' . esc_html( wp_kses_post( $this->ReceiverVENMONo ) ) . '" target="_blank">' . esc_html( wp_kses_post( $this->ReceiverVENMONo ) ) . '</a>.';
$email = ' ' . esc_html__( 'You can also email', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ' <a href="mailto:' . esc_html( wp_kses_post( $this->ReceiverVENMOEmail ) ) . '" target="_blank">' . esc_html( wp_kses_post( $this->ReceiverVENMOEmail ) ) . '</a>';
$checkout_html .= '<p>' . esc_html__( 'If you are having an issue', WCVENMO_PLUGIN_TEXT_DOMAIN ) . ', ' . wp_kses_post( ( $call ? $call : '' ) ) . wp_kses_post( ( $email ? $email : '' ) ) . '</p>';
// toggleTutorial
if ( 'yes' === $this->toggleTutorial ) {
    $checkout_html .= '<p><a href="https://theafricanboss.com/venmodemo" style="text-decoration: underline" target="_blank">' . esc_html__( 'See this 1min video demo explaining how this works', WCVENMO_PLUGIN_TEXT_DOMAIN ) . '.</a></p>';
}
// // toggleCredits
// if ( 'yes' === $this->toggleCredits ) {
// 	$checkout_html .= '<p><a href="https://theafricanboss.com/venmo" style="text-decoration: underline;" target="_blank">' . sprintf( esc_html__( 'Powered by %s', WCVENMO_PLUGIN_TEXT_DOMAIN ), 'The African Boss' ) . '</a></p>';
// }
do_action( 'woocommerce_form_end', $this->id );
$checkout_html .= '<div class="clear"></div></fieldset>';
echo $checkout_html;
//return $checkout_html;