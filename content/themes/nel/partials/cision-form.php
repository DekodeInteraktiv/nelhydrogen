<?php
/*

Fields:

• redirectUrlSubscribtionSuccess
Should point to a URL located on the client side that displays a ―registration success‖ message.

• redirectUrlSubscriptionFailed
Should point to a URL located on the client side that displays a ―registration failed‖ message.

• Language
The Language is set to the release language that the subscriber wants the information to be sent in. This is the language that the subscription will be saved as.
The format of the language codes is ISO 639 (2-letter).
See: http://www.loc.gov/standards/iso639-2/php/code_list.php for more specific information on language codes.

• ReplyLanguage
The wpyReplyLanguage is set to the desired language that the opt-in, confirmation and end-subscription mail will be sent in.
The format of the language codes is ISO 639 (2-letter).
See http://www.w3.org/WAI/ER/IG/ert/iso639.htm for more specific information on which code to use.

• Informationtype (Cannot be used together with custom categories)
Annual Financial Statement => KMK
Annual report/ annual accounts => RDV
Company Announcement/Press release => PRM
Interim report => RPT
Invitation => INB
Newsletter => NBR
It's possible to use multiple (as checkbox) + multiple as value => ie <input value="kmk,rpt">


• Name
The name of the subscriber

• CompanyName
The company name the subscriber

• Email
Email is the email address that the subscriber wants to get the information to.

• Cellphone
Cellphone is the cellular phone number that the subscriber wants to get the information to

• Iptc
If used the subscriber will only receive releases of the selected iptc code.

• CustomCategory (Cannot be used together with information types)
If used the subscriber will only receive the releases of the selected custom category.

• subscriberCountryCode
The country name the subscriber. Uses the ISO 3166 standard for values

• Customized Fields
Add your own customized field to the subscription form through naming the input as
<input name=”CustomField.[KEY]” where [KEY] is the name of your customized field.
<input type="text" name="CustomField.Website" id="Website" />

• Specialized Input Fields
Theses input fields may be used to get a more specified subscription. First an example code.
<p><b>IPTC</b></p>
<p>
<input type="checkbox" name="iptc" VALUE="[iptc value]"/>
<label>04004003</label><br />
<input type="checkbox" name="iptc" VALUE="[iptc value]"/>
<label>04007005</label><br />
White Paper - WPY - Subscription
Document: P2_Subscription.doc
Updated: 2016-01-26 Sida 5 av 6
5
</p>
<p><b>Custom Category</b></p>
<p>
<input type="checkbox" name="CustomCategory" VALUE="[category CODE]"/>
<label>Cat1</label><br />
<input type="checkbox" name="CustomCategory" VALUE="[category CODE]"/>
<label>Cat2</label><br />
</p>
<label for="subscriberCountyCode">Country</label><br/>
<select name="subscriberCountryCode" id="subscriberCountyCode"/>
<option value="se">Sweden</option>
<option value="gb">United kingdom</option>
<option value="us">USA</option>
<option value="is">Iceland</option>
</select>

*/

//$page_url = home_url($_SERVER['REQUEST_URI']);
$page_url = home_url( strtok( $_SERVER["REQUEST_URI"], '?' ) );

$endpoint       = 'https://publish.ne.cision.com/Subscription/Subscribe';
$identifier     = '337f0c2d0d';
$succress_url   = $page_url . '?success=true';
$error_url      = $page_url . '?success=false';
$reply_language = 'EN';
$message        = '';
$validation     = '';
$field_warnings = [];
$form_class     = [ 'cision-form' ];
$success        = false;

if ( isset( $_GET['success'] ) ) {

	$form_class[] = 'cision-form-scrollto';

	if ( $_GET['success'] == 'true' ) {

		$success = true;

	} else {

		$message = _x( 'Could not subscribe. Errors have been highlighted below.', 'Cision signup form', 'nel' );

		if ( isset( $_GET['ERROR'] ) ) {

			$errors = explode( ',', $_GET['ERROR'] );

			foreach ( $errors as $error ) {
				switch ( $error ) {

					case 'SUBSCRIPTION_UNIQUE_IDENTIFIER_MISSING':
						if ( current_user_can( 'edit_posts' ) ) {
							$message .= ' <br>The form does not have a unique identifier.';
						}
						break;

					case 'EMAIL_MISSING':
						$field_warnings['Email'] = ' ' . _x( 'This field is required.', 'Cision signup form', 'nel' );
						break;

					case 'INVALID_EMAIL_FORMAT':
						$field_warnings['Email'] = ' ' . _x( 'This is not a valid email.', 'Cision signup form', 'nel' );
						break;

				}
			}
		}

		if ( current_user_can( 'manage_options' ) ) {
			$message .= '<br><pre>' . print_r( $_GET, true ) . '</pre>';
		}

		$validation = '<div class="validation_error">' . $message . '</div>';
	}

}
?>

<?php if ( $success ) : ?>

    <div class="cision-form-success cision-form-scrollto bg-primary">
        <h3><?php _ex( 'Thank you for subscribing', 'Cision signup form', 'nel' ); ?></h3>
        <p><?php
			_ex( 'Your sign-up request was successful! Please check your email inbox to confirm.', 'Cision signup form', 'nel' );
			$reload_link = $page_url . '#cision-form';
			?><br><span
                    class="small"><?php echo sprintf( _x( '<a href="%s">Reload the page</a> if you wish to make another subscription.', 'Cision signup form', 'nel' ), $reload_link ); ?></span>
        </p>
    </div>

<?php else: ?>

    <div id="cision-form" class="gform_wrapper">

        <form method="post" class="<?php echo implode( ' ', $form_class ); ?>" action="<?php echo $endpoint; ?>"
              name="pageForm">

            <input type="hidden" name="subscriptionUniqueIdentifier" value="<?php echo $identifier; ?>"/>
            <input type="hidden" name="redirectUrlSubscriptionSuccess" value="<?php echo $succress_url; ?>"/>
            <input type="hidden" name="redirectUrlSubscriptionFailed" value="<?php echo $error_url; ?>"/>
            <input type="hidden" name="Replylanguage" value="<?php echo $reply_language; ?>"/>

			<?php echo $validation; ?>

            <ul class="gform_fields">
				<?php
				$fields = array(
					'Name'        => array(
						'label' => _x( 'Full name', 'Cision signup form', 'nel' ),
						'type'  => 'text'
					),
					'Email'       => array(
						'label'    => _x( 'Email', 'Cision signup form', 'nel' ),
						'type'     => 'email',
						'required' => true
					),
					'CompanyName' => array(
						'label' => _x( 'Company or Organization', 'Cision signup form', 'nel' ),
						'type'  => 'text'
					),
				);
				foreach ( $fields as $key => $field ) {

					$required      = '';
					$field_classes = [ 'gfield' ];
					if ( isset( $field_warnings[ $key ] ) ) {
						$field_classes[] = 'gfield_error';
					}

					if ( isset( $field['required'] ) && $field['required'] == true ) {
						$required = '<span class="gfield_required">*</span>';
					}
					?>
                    <li class="<?php echo implode( ' ', $field_classes ); ?>">
                        <label class="gfield_label"
                               for="<?php echo $key; ?>"><?php echo $field['label']; ?><?php echo $required; ?></label>
                        <div class="ginput_container">
                            <input class="cision-autofill" id="<?php strtolower( $key ); ?>" name="<?php echo $key; ?>"
                                   type="<?php echo $field['type']; ?>"
                                   value="<?php echo isset( $_GET[ $key ] ) ? $_GET[ $key ] : ''; ?>">
                        </div>
						<?php
						if ( isset( $field_warnings[ $key ] ) ) {
							?>
                            <div class="gfield_description validation_message"><?php echo $field_warnings[ $key ]; ?></div>
							<?php
						}
						?>
                    </li>
					<?php
				}
				?>

            </ul>

            <input type="submit" value="Submit">

        </form>
    </div>

<?php endif; ?>