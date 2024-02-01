<?php

/**
 * For each activate consent type a banner is created
 * If A/B testing is enabled, each banner is rendered per consenttype as well.
 */

	//Part of the template is used to render category toggles on the Cookie Policy document
	//Appending a random string to ID and for-elements allows multiple instances of toggles to co-exist
	$unique = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);;

?>
<div class="cmplz-cookiebanner cmplz-hidden banner-{id} {consent_type} cmplz-{position} cmplz-categories-type-{use_categories}" aria-modal="true" data-nosnippet="true" role="dialog" aria-live="polite" aria-labelledby="cmplz-header-{id}-{consent_type}" aria-describedby="cmplz-message-{id}-{consent_type}">

	<div class="cmplz-cookiebanner__container">

		<div class="cmplz-divider cmplz-divider-header"></div>

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
					<p id="cmplz-message-{id}-{consent_type}"><?php _e('This website uses required cookies to ensure the basic functionality and performance. In addition, we use targeting cookies to improve the user experience, perform analytics and display personalised content.', 'helsinki-universal') ?></p>
				</div>
			</div>


		</div>

		<div class="cmplz-links cmplz-information">
			<a class="cmplz-link cmplz-manage-options cookie-statement" href="#" data-relative_url="#cmplz-manage-consent-container"><?php _e("Manage options","complianz-gdpr")?></a>
			<a class="cmplz-link cmplz-manage-third-parties cookie-statement" href="#" data-relative_url="#cmplz-cookies-overview"><?php _e("Manage services","complianz-gdpr")?></a>
			<a class="cmplz-link cmplz-manage-vendors tcf cookie-statement" href="#" data-relative_url="#cmplz-tcf-wrapper"><?php _e("Manage vendors","complianz-gdpr")?></a>
			<a class="cmplz-link cmplz-external cmplz-read-more-purposes tcf" target="_blank" rel="noopener noreferrer nofollow" href="https://cookiedatabase.org/tcf/purposes/"><?php _e("Read more about these purposes","complianz-gdpr")?></a>
			<?php do_action("cmplz_after_links")?>
		</div>

		<div class="cmplz-divider cmplz-footer"></div>

		<div class="cmplz-links cmplz-documents">
			<a class="cmplz-link cookie-statement" href="#" data-relative_url="">{title}</a>
			<a class="cmplz-link privacy-statement" href="#" data-relative_url="">{title}</a>
			<a class="cmplz-link impressum" href="#" data-relative_url="">{title}</a>
			<?php do_action("cmplz_after_documents")?>
		</div>

		<div class="cookie-categories-wrap">
			<div class="cmplz-categories">
				<div class="cmplz-categories-inner">
					<div class="cmplz-categories-wrap">
						<label class="cmplz-category cmplz-functional" for="cmplz-functional-{consent_type}-<?php echo $unique; ?>">
							<div class="cmplz-slider-checkbox">
								<input type="checkbox"
										aria-checked="true"
										id="cmplz-functional-{consent_type}-<?php echo $unique; ?>"
										data-category="cmplz_functional"
										class="cmplz-consent-checkbox cmplz-functional"
										size="40"
										value="1"
										disabled />
								<span class="cmplz-slider cmplz-round"></span>
							</div>
							<span class="cmplz-label" tabindex="0">{category_functional}</span>
						</label>
					</div>

					<div class="cmplz-categories-wrap">
						<label class="cmplz-category cmplz-preferences" for="cmplz-preferences-{consent_type}-<?php echo $unique; ?>">
							<div class="cmplz-slider-checkbox">
								<input type="checkbox"
										id="cmplz-preferences-{consent_type}-<?php echo $unique; ?>"
										data-category="cmplz_preferences"
										class="cmplz-consent-checkbox cmplz-preferences"
										size="40"
										value="1"/>
								<span class="cmplz-slider cmplz-round"></span>
							</div>
							<span class="cmplz-label" tabindex="0">{category_preferences}</span>
						</label>
					</div>

					<div class="cmplz-categories-wrap">
						<label class="cmplz-category cmplz-statistics" for="cmplz-statistics-{consent_type}-<?php echo $unique; ?>">
							<div class="cmplz-slider-checkbox">
								<input type="checkbox"
										id="cmplz-statistics-{consent_type}-<?php echo $unique; ?>"
										data-category="cmplz_statistics"
										class="cmplz-consent-checkbox cmplz-statistics"
										size="40"
										value="1"/>
								<span class="cmplz-slider cmplz-round"></span>
							</div>
							<span class="cmplz-label" tabindex="0">{category_statistics}</span>
						</label>
					</div>

					<div class="cmplz-categories-wrap">
						<label class="cmplz-category cmplz-marketing" for="cmplz-marketing-{consent_type}-<?php echo $unique; ?>">
							<div class="cmplz-slider-checkbox">
								<input type="checkbox"
										id="cmplz-marketing-{consent_type}-<?php echo $unique; ?>"
										data-category="cmplz_marketing"
										class="cmplz-consent-checkbox cmplz-marketing"
										size="40"
										value="1"/>
								<span class="cmplz-slider cmplz-round"></span>
							</div>
							<span class="cmplz-label" tabindex="0">{category_marketing}</span>
						</label>
					</div>
				</div>
			</div>
		</div>

		<?php do_action('cmplz_banner_after_categories' ) ?>

		<div class="cmplz-buttons">
			<button class="cmplz-btn cmplz-accept"><?php _e('Accept all cookies', 'helsinki-universal') ?></button>
			<button class="cmplz-btn cmplz-deny"><?php _e('Accept required cookies only', 'helsinki-universal') ?></button>
			<button class="cmplz-btn cmplz-view-preferences"><?php _e('Show cookie settings', 'helsinki-universal') ?></button>
			<button class="cmplz-btn cmplz-save-preferences"><?php _e('Accept selected cookies', 'helsinki-universal') ?></button>
			<a class="cmplz-btn cmplz-manage-options tcf cookie-statement" href="#" data-relative_url="#cmplz-manage-consent-container">{manage_options}</a>

			<?php do_action("cmplz_after_buttons")?>
		</div>

	</div>

</div>
