<?php

/**
 * For each activate consent type a banner is created
 * If A/B testing is enabled, each banner is rendered per consenttype as well.
 */

	//Part of the template is used to render category toggles on the Cookie Policy document
	//Appending a random string to ID and for-elements allows multiple instances of toggles to co-exist
	$unique = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);;

?>
<!-- Header - Including Logo, Title, Close Icon -->
<div class="cmplz-cookiebanner cmplz-hidden banner-{id} {consent_type} cmplz-{position} cmplz-categories-type-{use_categories}" aria-modal="true" data-nosnippet="true" role="dialog" aria-live="polite" aria-labelledby="cmplz-header-{id}-{consent_type}" aria-describedby="cmplz-message-{id}-{consent_type}">
	<!--<div class="cmplz-header">
		<div class="cmplz-title screen-reader-text" id="cmplz-header-{id}-{consent_type}">{header}</div>
		<div class="cmplz-logo">{logo}</div>
		<a class="cmplz-close" tabindex="0" role="button">
			<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
		</a>
	</div>-->

	<div class="cmplz-cookiebanner__container">

		<!-- Divider between Header and Body -->

		<div class="cmplz-divider cmplz-divider-header"></div>

		<!-- Body -->
		<div class="cmplz-body">
			<div class="cmplz-message">
				<div class="cookie-notice">
					<h2 class="cookie-notice__title" id="cmplz-header-{id}-{consent_type}">
						<?php echo sprintf(
							'%s %s',
							get_bloginfo( 'name' ),
							esc_html_x('uses cookies', 'cookie notice title prefix', 'helsinki-universal')
						); ?>
					</h2>
					<p id="cmplz-message-{id}-{consent_type}"><?php esc_html_e('This website uses required cookies to ensure the basic functionality and performance. In addition, we use targeting cookies to improve the user experience, perform analytics and display personalised content.', 'helsinki-universal') ?></p>
				</div>
			</div>

		</div>

		<!-- Body - Hyperlinks for TCF -->

		<div class="cmplz-links cmplz-information">
			<a class="cmplz-link cmplz-manage-options cookie-statement" href="#" data-relative_url="#cmplz-manage-consent-container"><?php esc_html_e("Manage options","complianz-gdpr")?></a>
			<a class="cmplz-link cmplz-manage-third-parties cookie-statement" href="#" data-relative_url="#cmplz-cookies-overview"><?php esc_html_e("Manage services","complianz-gdpr")?></a>
			<a class="cmplz-link cmplz-manage-vendors tcf cookie-statement" href="#" data-relative_url="#cmplz-tcf-wrapper"><?php esc_html_e("Manage vendors","complianz-gdpr")?></a>
			<a class="cmplz-link cmplz-external cmplz-read-more-purposes tcf" target="_blank" rel="noopener noreferrer nofollow" href="https://cookiedatabase.org/tcf/purposes/"><?php _e("Read more about these purposes","complianz-gdpr")?></a>
			<?php do_action("cmplz_after_links")?>
		</div>

		<!-- Footer -->

		<!-- Footer - Hyperlinks Legal Documents -->
		<div class="cmplz-links cmplz-documents">
			<a class="cmplz-link cookie-statement" href="#" data-relative_url="">{title}</a>
			<a class="cmplz-link privacy-statement" href="#" data-relative_url="">{title}</a>
			<a class="cmplz-link impressum" href="#" data-relative_url="">{title}</a>
			<?php do_action("cmplz_after_documents")?>
		</div>

		<!-- Footer - Buttons -->

		<div class="cmplz-buttons">
			<button class="hds-button hds-button--secondary cmplz-accept">
				<?php esc_html_e('Accept all cookies', 'helsinki-universal') ?>
			</button>
			<button class="hds-button hds-button--secondary cmplz-deny">
				<?php esc_html_e('Accept required cookies only', 'helsinki-universal') ?>
			</button>
			<button
				id="cmplz-cookie-banner-categories-toggle-<?php echo $unique; ?>"
				class="hds-button hds-button--secondary cmplz-view-preferences"
				aria-controls="cmplz-cookie-banner-categories-<?php echo $unique; ?>"
				aria-expanded="false"
				onClick="this.setAttribute('aria-expanded', 'true');">
				<?php esc_html_e('Show cookie settings', 'helsinki-universal') ?>
			</button>
			<button class="hds-button hds-button--secondary cmplz-save-preferences">
				<?php esc_html_e('Accept selected cookies', 'helsinki-universal') ?>
			</button>

			<?php do_action("cmplz_after_buttons")?>
		</div>

		<!-- Footer - Categories -->

		<!-- categories start -->
		<div
			id="cmplz-cookie-banner-categories-<?php echo $unique; ?>"
			class="cookie-categories-wrap"
			aria-labelledby="cmplz-cookie-banner-categories-toggle-<?php echo $unique; ?>">
			<div class="cmplz-categories">
				<div class="cmplz-categories-inner">
					<!-- Body - Categories - Functional -->
					<div class="cmplz-categories-wrap">
						<div class="hds-checkbox">
							<input type="checkbox"
									aria-checked="true"
									id="cmplz-functional-{consent_type}-<?php echo $unique; ?>"
									data-category="cmplz_functional"
									class="hds-checkbox__input cmplz-functional"
									size="40"
									value="1"
									disabled />
							<label class="hds-checkbox__label cmplz-functional" for="cmplz-functional-{consent_type}-<?php echo $unique; ?>">
								{category_functional}
							</label>
						</div>
					</div>

					<!-- Body - Categories - Preferences -->
					<div class="cmplz-categories-wrap">
						<div class="hds-checkbox">
							<input type="checkbox"
									data-category="cmplz_preferences"
									class="hds-checkbox__input cmplz-preferences"
									size="40"
									value="1"/>
							<label class="hds-checkbox__label cmplz-preferences">
								{category_preferences}
							</label>
						</div>
					</div>

					<!-- Body - Categories - Statistics -->
					<div class="cmplz-categories-wrap">
						<div class="hds-checkbox">
							<input type="checkbox"
									id="cmplz-statistics-{consent_type}-<?php echo $unique; ?>"
									data-category="cmplz_statistics"
									class="hds-checkbox__input cmplz-statistics"
									size="40"
									value="1"/>
							<label class="hds-checkbox__label cmplz-statistics" for="cmplz-statistics-{consent_type}-<?php echo $unique; ?>">
								{category_statistics}
							</label>
						</div>
					</div>

					<!-- Body - Categories - Marketing -->
					<div class="cmplz-categories-wrap">
						<div class="hds-checkbox">
							<input type="checkbox"
									id="cmplz-marketing-{consent_type}-<?php echo $unique; ?>"
									data-category="cmplz_marketing"
									class="hds-checkbox__input cmplz-marketing"
									size="40"
									value="1"/>
							<label class="hds-checkbox__label cmplz-marketing" for="cmplz-marketing-{consent_type}-<?php echo $unique; ?>">
								{category_marketing}
							</label>
						</div>
					</div>
				</div>
			</div>
		</div><!-- categories end -->

		<?php do_action('cmplz_banner_after_categories' ) ?>

	</div>

</div>
