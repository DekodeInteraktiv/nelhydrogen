<?php
/*
// http://ir.asp.manamind.com/products/html/companyDisclosures.do?key=<YOURKEY>&lang=en&externalCss=http://acme.com/css/custom.css
// GUIDE: http://ir.asp.manamind.com/docs/OMS%20IR%20-%20Implementation%20Guide.pdf

http://ir.asp.manamind.com/products/html/companyDisclosures.do?key=nel&type=ÅRSRAPPORTER OG REVISJONSBERETNINGER

http://ir.asp.manamind.com/products/html/companyDisclosures.do?key=nel&numberOfDisclosures=0


http://ir.asp.manamind.com/products/xml/companyDisclosures.do?key=nel&lang=en&type=
http://ir.asp.manamind.com/products/xml/companyDisclosures.do?key=nel&lang=en&type=ÅRSRAPPORTER OG REVISJONSBERETNINGER
*/

/*
Header-text: #242432;
Gradient-from-color: #ffffff;
Gradient-to-color: #ffffff;
Volume bars: #b2b2b2;
Button color: #af00ff;
Button hover color: #242432;
Button text color: #ffffff;
Graph line: #af00ff;
Graph fill from (topp): #e8e8e8;
Graph fill to (bunn): #e8e8e8;
*/
?>
<div class="manamind-iframe-wrap">
	<?php $graphInteractiveUrl = '//ir.asp.manamind.com/irn/portal/component?component=graphInteractive&key=nel&lang=en'; ?>
    <iframe width="100%" height="100%" frameborder="0" scrolling="no"
            src="<?php echo $graphInteractiveUrl; ?>"></iframe>
</div>