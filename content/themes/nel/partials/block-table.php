<?php
// https://wordpress.org/plugins/advanced-custom-fields-table-field/
$table = get_sub_field( 'table' );
if ( $table ) :
	?>
    <section class="bg-gray section">
        <div class="section__content">
			<?php if ( get_sub_field( 'title' ) ) { ?>
                <header class="row section__header">
                    <div class="column">
                        <h3 class="section__title"><?php the_sub_field( 'title' ); ?></h3>
                    </div>
                </header>
			<?php } ?>
            <div class="row">
                <div class="columns">
                    <div class="table-overflow">
                        <div class="table-overflow__scroll">
                            <div class="table-overflow__content">
								<?php
								if ( $table ) {
									echo '<table border="0">';
									if ( $table['header'] ) {
										echo '<thead>';
										echo '<tr>';
										foreach ( $table['header'] as $key => $th ) {
											echo '<th>' . $th['c'] . '</th>';
										}
										echo '</tr>';
										echo '</thead>';
									}
									echo '<tbody>';
									foreach ( $table['body'] as $tr ) {
										echo '<tr>';
										foreach ( $tr as $key => $td ) {
											echo '<td><span class="td-content">' . nl2br( $td['c'] ) . '</span></td>';
										}
										echo '</tr>';
									}
									echo '</tbody>';
									echo '</table>';
								}
								?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
endif;
?>