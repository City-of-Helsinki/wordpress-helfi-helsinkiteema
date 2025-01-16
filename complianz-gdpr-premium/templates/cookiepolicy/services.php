<details class="cmplz-dropdown cmplz-service-desc cmplz-dropdown-cookiepolicy ">
	<summary class="cmplz-service-header">
		<span class="marker has-icon"><?php helsinki_svg_icon('angle-down'); ?></span>
		<span class="cmplz-title-wrap cmplz-service-title">
			<h4>{service}</h4>
		</span>
		<span class="purpose" >{allPurposes}</span>
	</summary>
    <div class="cmplz-service-description">
	    <span class="cmplz-title-wrap cmplz-description-title">
			<h5><?php echo esc_html_x("Usage", 'cookie policy', 'complianz-gdpr') ?></h5>
		</span>
		<p>{purposeDescription}</p>
    </div>
    <div class="cmplz-sharing-data">
        <span class="cmplz-title-wrap cmplz-sharing-title">
			<h5><?php echo esc_html_x("Sharing data", 'Legal document cookie policy', 'complianz-gdpr') ?></h5>
		</span>
		<p>{sharing}</p>
    </div>
	{cookies}
</details>
