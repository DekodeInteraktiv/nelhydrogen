<?php

$strings = array(
	'updated' => __( 'Shareholders in NEL ASA %s', 'nel' )
);

?>

<div class="row shareholders align-middle">
    <div class="column show-for-large large-6">
        <div class="pie-chart" data-strings='<?php echo json_encode( $strings ); ?>'
             data-xml="//ir.asp.manamind.com/products/xml/shareholders.do?key=nel&amp;lang=en">
            <div class="center-text"></div>
        </div>
    </div>
    <div class="column small-12 large-6">
        <table class="shareholder-table">
            <thead>
            <tr>
                <td><?php _e( 'Shares', 'nel' ); ?></td>
                <td>%</td>
                <td><?php _e( 'Shareholder', 'nel' ); ?></td>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<p class="shareholders-updated small"></p>
<p class="shareholders-disclaimer small"
   data-xml="//ir.asp.manamind.com/products/xml/disclaimerShareholders.do?key=nel&amp;lang=en"></p>