<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" omit-xml-declaration="yes" encoding="UTF-8" indent="no" />
	
	<xsl:template match="/view">
		<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>TechPub</title>
		
		<script>
			<xsl:text>GENTICS_Aloha_base="./techpub/assets/aloha/";</xsl:text>
		</script>
		<script type="text/javascript" src="{constants/aloha-url}/aloha.js"></script>
		<script type="text/javascript" src="{constants/aloha-url}/plugins/com.gentics.aloha.plugins.Format/plugin.js"></script>
		<script type="text/javascript" src="{constants/aloha-url}/plugins/com.gentics.aloha.plugins.Table/plugin.js"></script>
		<script type="text/javascript" src="{constants/aloha-url}/plugins/com.gentics.aloha.plugins.List/plugin.js"></script>
		<script type="text/javascript" src="{constants/aloha-url}/plugins/com.gentics.aloha.plugins.Link/plugin.js"></script>
		<link rel="stylesheet" href="{constants/aloha-url}/css/aloha.css" />
		
		<link rel="stylesheet" href="{constants/app-url}/assets/common.css" />
		<script src="{constants/app-url}/assets/common.js"></script>
		
		<div id="document">
			<div id="cover">
            	<h1>Gaia Retreat, from<br /> Drupal to Symphony</h1>
            	<p><sub>Date.</sub><br /> February 2011</p>
			</div>
            <div id="content">
            	<!--<h1>Gaia Retreat, from<br /> Drupal to Symphony</h1>-->
				<h2>Page layout</h2>
				<p>The Gaia Retreat website consists of a fairly simple three column layout:</p>
				<p>[Content layout diagram]</p>
				<p>As you can see, Column #3 is continuous down the page, however Column #2 can be viewed
				as multiple pieces running down the page and Column #1 is always inside Column 2 from a
				layout perspective. Column 1 is only ever used for displaying images related to the
				content in Column #2, so it makes sense that this would be the case.</p>
				<pre>class Main extends \Libs\View {
	public function resolveConstants() {
		$constants = \Libs\Session::current()->constants();
		$constants->{'aloha-url'} = $constants->{'app-url'} . '/assets/aloha';
	}
	
	public function isIndex() {
		return true;
	}
}</pre>
				<p>Additionally, Column #3 is not used on some pages and Column #2 stretches to fill up
				the space. Column 1 may also be empty, but content in Column #2 never fills that
				space.</p>
				<h2>Content layout</h2>
				<p>Content (Column #1&amp;2) can be seen as either one of two possible
				'blocks':<br /></p>
				<p>[Content layout diagram]</p>
				<p>Content Block #1 is used as a page header, it has:</p>
				<ul>
				<li>A large text header</li>
				<li>An upper navigation area below the header (optional)</li>
				<li>A lower navigation area below the content (optional)</li>
				<li>A right hand navigation area next to the content (optional)</li>
				<li>Images in Column #1 (optional)</li>
				<li>General copy text (optional)</li>
				</ul>
				<p>Content Block #2 is always after #1, it has:</p>
				<ul>
				<li>A medium text header (optional)</li>
				<li>General copy text</li>
				<li>A right hand navigation area next to the content (optional)</li>
				<li>Images in Column #1 (optional)</li>
				</ul>
				<p>The right aligned navigation areas may be used multiple times in one block.</p>
				<h2>Site structure</h2>
				<h3>Home page</h3>
				<p>The Gaia home page uses all three columns, with one #1 block. Inside of the main copy
				is an embedded navigation area which appears to be unique on this page.</p>
				<p>Column #1 contains the following promotions:</p>
				<ul>
				<li>Image rotator</li>
				<li>Nurture E-Newsletter</li>
				<li>Olivia Newton-John appeal badge</li>
				</ul>
				<h3>Pages index</h3>
				<ul>
				<li>/day-spa</li>
				<li>/gaia-experience</li>
				</ul>
				<p>Contains one #1 block with a header, optionally followed by multiple #2 blocks each
				with a single image and a 'View Details' button in the navigation area.</p>
				<p>Some of the #2 blocks are simply links back to other pages of the website, some are
				single content pages, the rest are index pages for deeper content.</p>
				<p>The data for all blocks on this page will come from the 'Pages' section.</p>
				<h3>Items index</h3>
				<ul>
				<li>/about-gaia</li>
				<li>/day-spa/&lt;page&gt;</li>
				<li>/gaia-experience/&lt;page&gt;</li>
				<li>/packages</li>
				</ul>
				<p>Contains one #1 block with a header and some copy. This may be followed by multiple #2
				blocks containing a single image and some copy.</p>
				<p>Depending on the individual entry, the right hand navigation may include a 'View
				Details' button and the header may include a price.</p>
				<p>The data for the #1 block on this page will come from the 'Pages' section, the data
				for the #2 blocks will come from the 'Items' section.</p>
				<h3>Item page</h3>
				<ul>
				<li>/about-gaia/&lt;item&gt;</li>
				<li>/day-spa/&lt;page&gt;/&lt;item&gt;</li>
				<li>/gaia-experience/&lt;page&gt;/&lt;item&gt;</li>
				<li>/packages/&lt;item&gt;</li>
				</ul>
				<p>Contains a single #1 block with copy, multiple images running down the side and
				optionally a single image at the bottom that when clicked triggers a slideshow.</p>
				<p>The right hand navigation may contain the following link, depending on the item:</p>
				<table>
				<tbody>
				<tr>
				<td>Enquire Now</td>
				<td>/enquire-now</td>
				</tr>
				</tbody>
				</table>
				<p>The lower navigation area contains a 'Back' link to the parent page if
				possible.<br /></p>
				<p>The data for the #1 block on this page will come from the 'Items' section.</p>
				<h3>Enquire Now</h3>
				<ul>
				<li>/enquire-now/&lt;id&gt;</li>
				</ul>
				<p>Contains a #1 block with a single form which allows people to make general enquiries
				to Gaia, or enquiries about:</p>
				<ul>
				<li>Retreat Packages</li>
				<li>Accommodation</li>
				<li>Day Spa Packages</li>
				</ul>
				<p>The form contains the following fields:</p>
				<ul>
				<li>Area of interest Select box of the above options, auto-selected by &lt;id&gt;</li>
				<li>Number of guests Select box 1 to 10 guests</li>
				<li>Date of interest Day/Month/Year select boxes</li>
				<li>Title Select box</li>
				<li>Name Text box</li>
				<li>Country Select box of Australia, New Zealand, England, Other</li>
				<li>Post code Text box</li>
				<li>Best contact number Text box</li>
				<li>Best time of day Select box of am and pm</li>
				<li>Email address Text box</li>
				<li>Message Text box<br /></li>
				<li>Data will be saved into the 'Enquiries' section.</li>
				</ul>
				<h3>Testimonials page<br /></h3>
				<ul>
				<li>/about-gaia/testimonials</li>
				</ul>
				<p>Contains one #1 block with a header and some copy. This may be followed by multiple #2
				blocks containing the full testimonial quote and author information.</p>
				<p>The data for the #1 block on this page will come from the 'Testimonials' section, the
				data for the #2 blocks on this page will come from the 'Testimonials' section.</p>
				<h3>Media reviews page</h3>
				<ul>
				<li>/about-gaia/media-reviews</li>
				</ul>
				<p>Contains a #1 block followed by a grid list of featured publications or article
				images, clicking on a publication brings up a light box with a complete set of images of
				the article and optional download link.</p>
				<p>The data for the #1 block on this page will come from the 'Media Reviews' section.</p>
				
				<h2>Sections</h2>
				<h3>About section</h3>
				
				<p>The settings section will be a single entry section that stores any misc text, such as
				error messages, footer text, used throughout the site, and also the image selection for
				the header image rotator.</p>
				<p>It contains the following fields:</p>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Contact details</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Footer copy</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Header images</td>
				<td>Subsection Manager</td>
				</tr>
				</table>
				
				<p>Will be placed in the <b>Site Management</b> navigation group.</p>
				
				<h3>Buttons section</h3>
				
				<p>The buttons section allows the client to define buttons to appear in various places
				attached to pages.</p>
				
				<table>
				<caption>Linked sections</caption>
				<tr>
				<td>Section</td>
				<td>Reason</td>
				</tr>
				<tr>
				<td>Pages</td>
				<td>Choose the pages that this button should appear under</td>
				</tr>
				</table>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				</tr>
				<tr>
				<td>Title</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Link</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Pages</td>
				<td>Select box link</td>
				</tr>
				<tr>
				<td>Positions</td>
				<td>Select box</td>
				</tr>
				</table>
				
				<p>Choose which navigation areas the item should appear in, none, upper, lower or both.</p>
				<p>Will be placed in the <b>Site Management</b> navigation group.</p>
				<h3>Enquiries section</h3>
				<p>The enquiries section stores any user information submitted from the Enquire Now
				page.</p>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				</tr>
				<tr>
				<td>Area of interest</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Number of guests</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Date of interest</td>
				<td>Date</td>
				</tr>
				<tr>
				<td>Title</td>
				<td>Text box<br /></td>
				</tr>
				<tr>
				<td>Name</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Country</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Post code</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Best contact number</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Best time of day</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Email address</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Message</td>
				<td>Text box</td>
				</tr>
				</table>
				
				<p>Will be placed in the <b>Inbox</b> navigation group.</p>
				
				<h3>Images section</h3>
				
				<p>The images section will be hidden from users, except through Subsection Manager fields.</p>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				</tr>
				<tr>
				<td>Title</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Image</td>
				<td>Advanced Upload</td>
				</tr>
				</table>
				
				<p>Will not be placed in any navigation group.</p>
				
				<h3>Items section<br /></h3>
				<p>Items are smaller pieces of copy similar to Pages, but with more specific meta
				information and the ability to enable a few extra features.</p>
				<p>The following sections are linked:</p>
				
				<table>
				<caption>Linked sections</caption>
				<tr>
				<td>Section</td>
				<td>Reason</td>
				</tr>
				<tr>
				<td>Pages</td>
				<td>Choose the page that this item should appear under</td>
				</tr>
				</table>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				<td>Description</td>
				</tr>
				<tr>
				<td>Title</td>
				<td>Text box</td>
				<td></td>
				</tr>
				<tr>
				<td>Brief</td>
				<td>Text box</td>
				<td>Index page contents</td>
				</tr>
				<tr>
				<td>Content</td>
				<td>Text box</td>
				<td>Main page content</td>
				</tr>
				<tr>
				<td>Notes</td>
				<td>Text box</td>
				<td>Used for entering prices<br />
				Displayed next to title</td>
				</tr>
				<tr>
				<td>Redirect</td>
				<td>Text box</td>
				<td>Provide an alternative link for the item</td>
				</tr>
				<tr>
				<td>Parent page</td>
				<td>Select Box Link</td>
				<td></td>
				</tr>
				<tr>
				<td>Related images</td>
				<td>Subsection Manager</td>
				<td>Uploading/ordering multiple images</td>
				</tr>
				<tr>
				<td>Show enquire button</td>
				<td>Check box</td>
				<td>Checked to place an 'Enquire Now' button<br />
				in the right hand navigation</td>
				</tr>
				<tr>
				<td>Show slideshow</td>
				<td>Check box</td>
				<td>Checked to display a slideshow after the content</td>
				</tr>
				</table>
				
				<p>Will be placed in the <b>Content</b> navigation group.<br /></p>
				
				<h3>Media reviews section</h3>
				<p>A collection of articles and images of those articles.</p>
				<p>It contains the following fields:</p>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				</tr>
				<tr>
				<td>Title</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Description</td>
				<td>Text box</td>
				</tr>
				<tr>
				<td>Download</td>
				<td>Advanced Upload</td>
				</tr>
				<tr>
				<td>Images</td>
				<td>Subsection Manager</td>
				</tr>
				</table>
				<p>Will be placed in the <b>Content</b> navigation group.<br /></p>
				
				<h3>Pages section</h3>
				<p>The pages section is the main generic content section of the site, it contains any
				meta data and SEO information as well as the main page content.</p>
				
				<table>
				<caption>Linked sections</caption>
				<tr>
				<td>Section</td>
				<td>Reason</td>
				</tr>
				<tr>
				<td>Pages</td>
				<td>Allow physical pages can have child pages</td>
				</tr>
				</table>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				<td>Description</td>
				</tr>
				<tr>
				<td>Title</td>
				<td>Text box</td>
				<td></td>
				</tr>
				<tr>
				<td>Description</td>
				<td>Text box</td>
				<td>SEO/Meta description</td>
				</tr>
				<tr>
				<td>Brief</td>
				<td>Text box</td>
				<td>Index page content</td>
				</tr>
				<tr>
				<td>Content</td>
				<td>Text box</td>
				<td>Main page content</td>
				</tr>
				<tr>
				<td>Redirect</td>
				<td>Text box</td>
				<td>Provide an alternative link for the page</td>
				</tr>
				<tr>
				<td>Parent page</td>
				<td>Select Box Link</td>
				<td></td>
				</tr>
				<tr>
				<td>Related images</td>
				<td>Subsection Manager</td>
				<td>Uploading/ordering multiple images</td>
				</tr>
				<tr>
				<td>Show details button</td>
				<td>Check Box</td>
				<td>Checked to place a 'View Details' button in the<br />
				right hand navigation of each #2 block</td>
				</tr>
				<tr>
				<td>Show pages</td>
				<td>Check Box</td>
				<td>Checked to list all child pages as #2 blocks</td>
				</tr>
				<tr>
				<td>Show items</td>
				<td>Check Box</td>
				<td>Checked to list all child items as #2 blocks</td>
				</tr>
				</table>
				
				<p>Will be placed in the <b>Content</b> navigation group.<br /></p>
				
				<h3>Promotions section</h3>
				<p>Promos are small snippets of content with a 'more' link and optionally some images.
				They are featured in Column #3 on most pages, but also Column #1 on the home page.</p>
				<p>Some promos have special features:</p>
				
				<ul>
				<li>Competition entry Brings up a competition entry form on click</li>
				<li>An image rotator Rotates through all attached images</li>
				<li>An image slideshow Shows the first image as a preview, shows slideshow on click</li>
				<li>A testimonial rotator Rotates through entries in the testimonials section</li>
				</ul>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				<td>Description</td>
				</tr>
				<tr>
				<td>Copy</td>
				<td>Text box</td>
				<td>The main promo text, including title (optional)</td>
				</tr>
				<tr>
				<td>Type</td>
				<td>Select box</td>
				<td>Choose a special feature for this promo, normal,<br />
				image rotator, image slideshow, testimonial rotator</td>
				</tr>
				<tr>
				<td>Image link</td>
				<td>Text box</td>
				<td>Any provided images, even in a rotator, will be<br />
				wrapped with this link</td>
				</tr>
				<tr>
				<td>Images</td>
				<td>Subsection Manager</td>
				<td><br /></td>
				</tr>
				</table>
				
				<p>Will be placed in the <b>Site Management</b> navigation group.<br /></p>
				
				<h3>Testimonials section</h3>
				
				<table>
				<caption>Section schema</caption>
				<tr>
				<td>Name</td>
				<td>Field</td>
				<td>Description</td>
				</tr>
				<tr>
				<td>Author</td>
				<td>Text box</td>
				<td></td>
				</tr>
				<tr>
				<td>Position</td>
				<td>Text box</td>
				<td></td>
				</tr>
				<tr>
				<td>Company</td>
				<td>Text box</td>
				<td></td>
				</tr>
				<tr>
				<td>Quote</td>
				<td>Text box</td>
				<td></td>
				</tr>
				<tr>
				<td>Show in rotator</td>
				<td>Check box</td>
				<td>Checked to show the entry in any<br />
				testimonial rotator promos</td>
				</tr>
				</table>
				
				<p>Will be placed in the <b>Content</b> navigation group.</p>
            </div>
        </div>
	</xsl:template>
</xsl:stylesheet>