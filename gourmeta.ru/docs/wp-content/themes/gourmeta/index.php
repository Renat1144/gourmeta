<? get_header() ?>

<? if (!isset($_GET['demo'])) : ?>
	<!-- Basic html styles and rich text editor elements -->
	<div class="col-wrapper col-box">
		<!-- 
			a page is build with rows and has child columns within each of these rows.
			a 6-column grid is used, see layout.css for details
		-->
		<div class="row">
			<div class="col col6of6">
				<? while (have_posts()) : the_post(); ?>
					<h1><? the_title(); ?></h1>
					<? the_content(); ?>
				<? endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
<? else : ?>	
	<!-- Pushbox -->
	<div class="branding-wrapper">
		<!-- data-decs-pushbox-pause is the pause in seconds for each rotation -->
		<div class="pushbox" data-decs-pushbox-pause="5">
			<!-- main viewport with slides -->
			<div class="pushbox-viewport">		
				<ul class="pushbox-slides">
					<li>
						<div class="text-box">
							<h3>1. Your office coffee solution: the right blend for hard work</h3>
							<a href="" class="button">Learn more<span><span></span></span></a>
							<a href="" class="button-yellow button button-video">Play video<span><span></span></span></a>
						</div>
						<div class="mediaplayer-wrapper">
							<!-- generate unique id for each video-->
							<div id="mediaplayer" class="video">
								<a href="<?= bloginfo('template_url') ?>/js/jwplayer/video.mp4">
									<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox.jpg" alt="" />
								</a>
							</div>
						</div>
					</li>
					<li>
						<div class="text-box">
							<h3>2. Your office coffee solution: the right blend for hard work</h3>
							<a href="" class="button">Learn more<span><span></span></span></a>
						</div>
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox.jpg" alt="" />
					</li>
					<li>
						<div class="text-box">
							<h3>3. Your office coffee solution: the right blend for hard work</h3>
							<a href="" class="button">Learn more<span><span></span></span></a>
						</div>
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox2.jpg" alt="" />
					</li>
				</ul>
			</div>

			<!-- pushbox navigation  -->
			<div class="pushbox-nav">
				<ul>
					<li>1</li>
					<li>2</li>
					<li>3</li>
				</ul>
			</div>

			<a class="pushbox-next">next</a>
			<a class="pushbox-prev">previous</a>

			<div class="row col-box pushbox-teasers">
				<div class="pushbox-teasers-box clearfix">
					<div class="slide-teasers" data-decs-slideindex="0"> <!-- teasers for slide 1 -->
						<div class="slide-teaser">
							<a class="col col-2of6">
								<span></span>
								<h3>1 Our products</h3>
								<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox-small.jpg" alt="Hotels &amp; restaurants" />
								<p>We offer state of the art coffee machines, premium quality and accessories.</p>
							</a>
						</div>
						<div class="slide-teaser-seperator"></div>
						<div class="slide-teaser">
							<a class="col col-2of6">
								<span></span>
								<h3>1 Our products</h3>
								<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox-small.jpg" alt="Hotels &amp; restaurants" />
								<p>We offer state of the art coffee machines, premium quality and accessories.</p>
							</a>
						</div>
						<div class="slide-teaser">
							<a class="col col-2of6">
								<span></span>
								<h3>1 Our products</h3>
								<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox-small.jpg" alt="Hotels &amp; restaurants" />
								<p>We offer state of the art coffee machines, premium quality and accessories.</p>
							</a>
						</div>
					</div>

					<div class="slide-teasers" data-decs-slideindex="1"> <!-- teasers for slide 2 -->
						<div class="slide-teaser">
							<a class="col col-2of6">
								<span></span>
								<h3>2 Our products</h3>
								<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox-small.jpg" alt="Hotels &amp; restaurants" />
								<p>We offer state of the art coffee machines, premium quality and accessories.</p>
							</a>
						</div>
						<div class="slide-teaser">
							<a class="col col-2of6">
								<span></span>
								<h3>2 Our products</h3>
								<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox-small.jpg" alt="Hotels &amp; restaurants" />
								<p>We offer state of the art coffee machines, premium quality and accessories.</p>
							</a>
						</div>
					</div>

					<div class="slide-teasers" data-decs-slideindex="2"> <!-- teasers for slide 3 -->
						<div class="slide-teaser">
							<a class="col col-2of6">
								<span></span>
								<h3>3 The coffee journey</h3>
								<img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox-small.jpg" alt="Hotels &amp; restaurants" />
								<p>Everything you need to know about coffee from the bean to the cup.</p>
							</a>
						</div>
					</div>
				</div>			
			</div>
			<div class="pushbox-teasers-shadow"></div>
		</div>
	</div>

	<!-- Basic html styles and rich text editor elements -->
	<div class="col-wrapper col-box">
		<!-- 
			a page is build with rows and has child columns within each of these rows.
			a 6-column grid is used, see layout.css for details
		-->
		<div class="row">
			<div class="col col6of6">
				<h1>Dit is een h1</h1>
				<h1><a>Dit is een h1</a></h1>
				<p class="intro"><strong>strong</strong> <sub>sub</sub> <a href="">een link</a><sup>sup</sup>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>
				<p><strong>strong</strong> <sub>sub</sub> <a href="">een link</a><sup>sup</sup>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>
				<h2>Dit is een h2</h2>
				<p class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>
				<h3><a>Dit is een h3</a></h3>
				<p class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>
				<h4>Dit is een h4</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>
				<h5>Dit is een h5</h5>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>
				<h6>Dit is een h5</h6>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quam nunc, commodo eget auctor et, cursus non metus. Nullam interdum eros ac est placerat faucibus. Nunc vel dolor orci, at euismod nibh. Curabitur ornare lobortis purus, hendrerit mollis arcu semper congue. Cras a enim lacus. Vestibulum quis elit in metus elementum pretium. Duis sit amet augue orci.</p>

				<ul>
					<li>item 1</li>
					<li>item 1</li>
					<li>item 1</li>
					<li>item 1</li>
					<li>item 1</li>
				</ul>

				<ol>
					<li>item 1</li>
					<li>item 1</li>
					<li>item 1</li>
					<li>item 1</li>
					<li>item 1</li>
				</ol>

				<pre>This is a       pre tag</pre>
				<br /><sub>sub</sub>
				<br /><sup>sup</sup>
				<br /><q>quote</q>
				<br /><blockquote><p>blockquote</p></blockquote>
				
				<table>
					<thead>
						<tr>
							<th>1</th>
							<th>1</th>
							<th>1</th>
							<th>1</th>
							<th>1</th>
						</tr>
						<tr>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>1</th>
							<th>1</th>
							<th>1</th>
							<th>1</th>
							<th>1</th>
						</tr>
						<tr>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
						</tr>
					</tfoot>
					<tbody>
						<tr>
							<th>1</th>
							<th>1</th>
							<th>1</th>
							<th>1</th>
							<th>1</th>
						</tr>
						<tr>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
						</tr>
					</tbody>
				</table>

				<!-- all available buttons and link elements -->
				<a class="readmore">Read more link</a>
				<br /><a class="return">Return link</a>
				<br /><a class="button">button <span><span></span></span></a>
				<br /><a class="button button-yellow">button <span><span></span></span></a>
				<br /><a href="tel:0302312108" class="call-link">030 23 12 108<span></span></a>
				<br /><a href="" class="print-link">print this comparison<span></span></a>
				<br /><a href="" class="share-link">Share this comparison<span></span></a>
				<br /><a href="callmeback.html" rel="shadowbox;width=550;">Open form in shadowbox</a>

				<hr />

				<!-- form elements styling using xForms -->
				<fieldset>

					<!-- heading -->
					<div class="form-item">
						<span class="head">Form elements: Html is from the output of Xforms (episerver form module)</span>
					</div>

					<!-- input -->
					<div class="form-item">
						<label for="">Initials</label>
						<input type="text" value="" name="" id="" size="5" /><span class="xformvalidator" style="color:Red;display:none;">This field is required</span>
					</div>

					<!-- textarea -->
					<div class="form-item">
						<label for="">Question or extra information</label>
						<textarea cols="20" name="" id="" rows="4"></textarea>
					</div>

					<!-- radios -->
					<div class="form-item">
						<fieldset>
							<legend>Type of client</legend>
							<input type="radio" id="men" name="radio" value="New" /><label for="men">New client</label>
							<input type="radio" id="female" name="radio" value="Existing" /><label for="female">Existing client</label>
						</fieldset>
						<span style="color:Red;display:none;" class="xformvalidator" id="">This field is required</span>
					</div>

					<!-- select -->
					<div class="form-item">
						<label for="">Country</label>
						<select name="" id="">
							<option selected="selected" value="Netherlands">Netherlands</option>
							<option value="Belgium">Belgium</option>
						</select>
						<span style="color:Red;display:none;" class="xformvalidator">This field is required</span>
					</div>

					<!-- checkbox -->
					<div class="form-item">
						<fieldset>
							<input type="checkbox" id="" name="" value="Receive monthly tips" />
							<label for="">Receive monthly tips</label>
						</fieldset>
					</div>

					<!-- seperator -->
					<div class="form-item">
						<hr />
					</div>

					<!-- submit -->
					<div class="form-item">
						<input type="submit" onclick="" name="" value="Submit" />
					</div>

				</fieldset>

			</div>
		</div>
	</div>

	<!-- use .col-box for blocks with a border -->
	<div class="col-wrapper col-box">

		<div class="row">
			<h2>Explore extra value to your business here</h2>
			<!-- use column classes for specific styling for columns: see layout.css-->
			<div class="clearfix text-center child-pages">
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual-108x108.jpg" alt="Bareca" />
						Bareca
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual2-108x108.jpg" alt="Health &amp; care" />
						Health &amp; care
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual3-108x108.jpg" alt="Hotels" />
						hotels
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual-108x108.jpg" alt="Bareca" />
						Bareca
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual2-108x108.jpg" alt="Health &amp; care" />
						Health &amp; care
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual3-108x108.jpg" alt="Hotels" />
						hotels
					</a>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- use border-curved to make curved seperators or use hr.curved within columns -->
			<div class="col col-6of6 border-curved"></div>
		</div>

		<!-- use heading-underline for underlined headings within a block -->
		<div class="row heading-underline border-curved">
			<div class="col col-2of6">
				<h3>Hotels &amp; restaurants</h3>
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual-252x142.jpg" alt="Hotels &amp; restaurants" />
				<p>Complete range of coffee solutions and supporting products to match your needs.</p>
				<a href="" class="button">Coffee concepts<span><span></span></span></a>
			</div>
			<div class="col col-2of6">
				<h3>Coffee like home</h3>
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual2-252x142.jpg" alt="Coffee like home" />
				<p>Customer demand for sustainable products continues to increase dramatically. Douwe Egberts can help you capitalize on this trend.</p>
				<a href="" class="button">Coffee service<span><span></span></span></a>
			</div>
			<div class="col col-2of6">
				<h3>Sustainable coffee</h3>
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual3-252x142.jpg" alt="Sustainable coffee<" />
				<p>Your clients vary quick, therefor we have selected different blends for you, of the best sustainable and honest coffee. </p>
				<a href="" class="button">Sustainable Coffee<span><span></span></span></a>
			</div>
		</div>

		<!-- use text-center to set text-center on child .col's -->
		<div class="row text-center border-curved">
			<div class="col col-2of6">
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual-252x142.jpg" alt="L'OR Espresso" />
				<p>Complete range of coffee solutions and supporting products to match your needs.</p>
				<a href="" class="readmore">More about L'OR Espresso</a>
			</div>
			<div class="col col-2of6">
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual3-252x142.jpg" alt="More about T-pads" />
				<p>Your clients vary quick, therefor we have selected different blends for you, of the best sustainable and honest coffee. </p>
				<a href="" class="readmore">More about T-pads</a>
			</div>
			<div class="col col-2of6">
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual2-252x142.jpg" alt="byproducts" />
				<p>Customer demand for sustainable products continues to increase dramatically. Douwe Egberts can help you capitalize on this trend.</p>
				<a href="" class="readmore">More about our byproducts</a>
			</div>
		</div>

		<!-- content: image right -->
		<div class="row">
			<div class="col col-3of6">
				<h2>UTZ certified, our worldwide warranty for sustainable coffee</h2>
				<p>To get the best quality and responsible coffee we invest in the Douwe Egberts foundation, which stimulates entrepeneurship of farmers and teachers them the need of sustainable coffee growing.</p>
				<a href="" class="button button-yellow">Find coffee needs<span><span></span></span></a>
			</div>
			<div class="col col-3of6">
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual-396x223.jpg" alt="UTZ certified, our worldwide warranty for sustainable coffee" />
			</div>
			
		</div>
		
		<!-- content: image left -->
		<div class="row">
			<div class="col col-3of6">
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual-396x223.jpg" alt="UTZ certified, our worldwide warranty for sustainable coffee" />
			</div>
			<div class="col col-3of6">
				<h2>UTZ certified, our worldwide warranty for sustainable coffee</h2>
				<p>To get the best quality and responsible coffee we invest in the Douwe Egberts foundation, which stimulates entrepeneurship of farmers and teachers them the need of sustainable coffee growing.</p>
				<a href="" class="button button-yellow">Find coffee needs<span><span></span></span></a>
			</div>
		</div>

		<!-- page introduction -->
		<div class="row">
			<div class="intro">
				<a class="return">Return link</a>
				<h1>Coffee Machines</h1>
				<p>Coffee at work is very important for employees and your clients. We understand this and serve you the best coffee to your needs.Coffee at work is very important for employees and your clients. We understand this and serve you the best coffee to your needs.</p>
			</div>
		</div>

		<!-- teasers-->
		<div class="row">
			<div class="col col-6of6">
				<ul class="nav teasers-related clearfix">
					<li>
						<!-- default color for teaser is -->
						<a href="">
							<img src="<?= bloginfo('template_url') ?>/img/temp/visual-189x106.jpg" width="189" height="106" alt="Our business" />
							<h3>Our business</h3>
							<p>To simply delight you <br />....every day.</p>
						</a>
					</li>
					<li>
						<!-- different colors for the teasers -->
						<a href="" class="black">
							<img src="<?= bloginfo('template_url') ?>/img/temp/visual-189x106.jpg" width="189" height="106" alt="Our business" />
							<h3>Our business</h3>
							<p>A-Brand, high quality coffee systems and coffees are the core of our coffee solutions approach.</p>
						</a>
					</li>
					<li>
						<a href="" class="red">
							<img src="<?= bloginfo('template_url') ?>/img/temp/visual-189x106.jpg" width="189" height="106" alt="Our business" />
							<h3>Our business</h3>
							<p>A-Brand, high quality coffee systems and coffee solutions approach.</p>
						</a>
					</li>
					<li>
						<a href="" class="green">
							<img src="<?= bloginfo('template_url') ?>/img/temp/visual-189x106.jpg" width="189" height="106" alt="Our business" />
							<h3>Our business</h3>
							<p>Coffees are the core of our coffee solutions approach.</p>
						</a>
					</li>
				</ul>
			</div>
		</div> 
	</div>

	<!-- search results -->
	<div class="col-wrapper col-box">
		<!-- specific classes can be set on the row -->
		<div class="row search">
			<div class="col col-6of6">
				<p class="search-summary">You searched for <strong>'Cafitesse'</strong></p>
				<ul>
					<li>
						<h3>How to clean a <strong>Cafitesse</strong> 50</h3>
						<p>De koelruimte van de machine biedt plaats aan twee ingredientpakken. Het rechter ingredientpak bevat altijd koffie. Afhankelijk van de ingredienten die u plaatst, kan de machine...</p>
						<a href="" class="readmore">Read more about How to clean a Cafitesse 50</a>
					</li>
					<li>
						<h3>How to clean a <strong>Cafitesse</strong> 50</h3>
						<p>De koelruimte van de machine biedt plaats aan twee ingredientpakken. Het rechter ingredientpak bevat altijd koffie. Afhankelijk van de ingredienten die u plaatst, kan de machine...</p>
						<a href="" class="readmore">Read more about How to clean a Cafitesse 50</a>
					</li>
					<li>
						<h3>How to clean a <strong>Cafitesse</strong> 50</h3>
						<p>De koelruimte van de machine biedt plaats aan twee ingredientpakken. Het rechter ingredientpak bevat altijd koffie. Afhankelijk van de ingredienten die u plaatst, kan de machine...</p>
						<a href="" class="readmore">Read more about How to clean a Cafitesse 50</a>
					</li>
					<li>
						<h3>How to clean a <strong>Cafitesse</strong> 50</h3>
						<p>De koelruimte van de machine biedt plaats aan twee ingredientpakken. Het rechter ingredientpak bevat altijd koffie. Afhankelijk van de ingredienten die u plaatst, kan de machine...</p>
						<a href="" class="readmore">Read more about How to clean a Cafitesse 50</a>
					</li>
					<li>
						<h3>How to clean a <strong>Cafitesse</strong> 50</h3>
						<p>De koelruimte van de machine biedt plaats aan twee ingredientpakken. Het rechter ingredientpak bevat altijd koffie. Afhankelijk van de ingredienten die u plaatst, kan de machine...</p>
						<a href="" class="readmore">Read more about How to clean a Cafitesse 50</a>
					</li>
					<li>
						<h3>[PDF] How to clean a <strong>Cafitesse</strong> 50</h3>
						<p>De koelruimte van de machine biedt plaats aan twee ingredientpakken. Het rechter ingredientpak bevat altijd koffie. Afhankelijk van de ingredienten die u plaatst, kan de machine...</p>
						<a href="" class="readmore">Read more about How to clean a Cafitesse 50</a>
					</li>
				</ul>
			</div>
		</div>
		
		<!-- paginator -->
		<div class="row paginator">
			<ul>
				<li class="previous"><span>Vorige</span></li>
				<li class="active"><span>1</span></li>
				<li><a href="">2</a></li>
				<li><a href="">3</a></li>
				<li class="next"><a href="">Volgende</a></li>
			</ul>
		</div>
	</div>

	<!-- 
		label-green makes use of waypoints.js 
		class is set on the col-wrapper instead of the row because it needs full width
	-->
	<div class="col-wrapper label-green">
		<div class="row">
			<div class="col col-2of6">
				<q>And then there's coffee... Douwe Egberts coffee</q>
				<p>Amanda Baker, England</p>
				<a href="">Read full story</a>
			</div>
			<div class="col col-2of6">
				<q>Puur delight from the best coffee there is lorem ipsum dolor sit</q>
				<p>Ruud van Dam, The Netherlands</p>
				<a href="">Read full story</a>
			</div>
			<div class="col col-2of6">
				<q>Can't go without a fresh cup of coffee...</q>
				<p>Elke de Jong, France</p>
				<a href="">Read full story</a>
			</div>
		</div>
	</div>

	<!-- quoteform -->
	<div class="col-wrapper col-box">
		<div class="row">
			<div class="quote-form">
				<h2>Select your machine of interest</h2>
				
				<!-- top of the container can be 3 different items -->

				<!-- item 1: input with search 
				<div class="form-item">
					<label>Machine or concept of interest</label>
					<input type="text" class="free-select-product" />
				</div>-->

				<!-- a single machine
				<div class="row quote-form-selection">
					<div class="col col-2of6">
						<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
						<h3>Cafitesse Excellence 1</h3>
					</div>
				</div> -->

				<!-- or several ones -->
				<div class="row quote-form-selection">
					<div class="col col-2of6">
						<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
						<h3>Cafitesse Excellence 1</h3>
						<label><input type="checkbox" /><span></span> Selected</label>
					</div>

					<div class="col col-2of6">
						<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
						<h3>Cafitesse Excellence 2</h3>
						<label><input type="checkbox" /><span></span> Selected</label>
					</div>

					<div class="col col-2of6">
						<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
						<h3>Cafitesse Excellence 3</h3>
						<label><input type="checkbox" /><span></span> Selected</label>
					</div>
				</div>
				
			</div>
			<div class="form-item">
				<input type="text" value="" name="ctl00$cphContent$ctl02$FormControl$ProductSelection" id="ctl00_cphContent_ctl02_FormControl_ProductSelection" class="HiddenXFormField" size="60" />
			</div>
		</div>
	</div>
	
	<!-- detail page intro -->
	<div class="col-wrapper col-wrapper-grey">
		<div class="row">
			<!-- image holder -->
			<div class="col col-2of6">
				<div class="image-holder">
					<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_50_216x348.png" alt="Machinenaam" />
					<img src="<?= bloginfo('template_url') ?>/img/temp/icon-certificate.png" alt="" class="watermark" />
				</div>
			</div>
			<div class="col col-4of6">
				<div class="intro">
					<h1>
						<span>Cafitesse 50</span>
					</h1>
					<div>
						<p>With lots of coffee options, a compact form and no dependency on mains water connection, the Cafitesse 60 is a great versatile machine for the office.</p>
					</div>
				</div>
				<div class="col-box call-to-action">
					<!-- example content -->
					<em>Interested?</em>

					<div class="call-button-holder">
						<div>
							<p>
								<a rel="shadowbox; width=510;height=540" class="button button" href="/nl-BE/global/popup-form-contact/">
									Call me back
									<span>
										<span></span>
									</span>
								</a>
								<a class="button button-yellow" href="/nl-BE/global/quote-form/?machines=606">
									Quote
									<span>
										<span></span>
									</span>
								</a>
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="col-wrapper-grey-bottom"></div>
	</div>	

	<!-- certificates-->
	<div class="col-wrapper">
		<div class="row">
			<div class="col col-3of6">
				<ul class="list-cols list-certificates">
					<li>
						<img src="<?= bloginfo('template_url') ?>/img/temp/icon-certificate.png" alt="About UTZ certified" /><br />
						<a href="" class="readmore">About UTZ certified</a>
					</li>
					<li>
						<img src="<?= bloginfo('template_url') ?>/img/temp/icon-certificate.png" alt="About UTZ certified" /><br />
						<a href="" class="readmore">About UTZ certified</a>
					</li>
					<li>
						<img src="<?= bloginfo('template_url') ?>/img/temp/icon-certificate.png" alt="About UTZ certified" /><br />
						<a href="" class="readmore">About UTZ certified</a>
					</li>
					<li>
						<img src="<?= bloginfo('template_url') ?>/img/temp/icon-certificate.png" alt="About UTZ certified" /><br />
						<a href="" class="readmore">About UTZ certified</a>
					</li>
				</ul>
			</div>
			<!-- highlights-->
			<div class="col col-3of6">
				<ul class="list-cols list-highlights">
					<li>Compact design</li>
					<li>Variations <span class="energy-label energy-label-a"><img src="<?= bloginfo('template_url') ?>/img/spr-energy-label.png" alt="Energy label A" />Energy label A</span></li>
					<li>Flexible in placement <span class="energy-label energy-label-b"><img src="<?= bloginfo('template_url') ?>/img/spr-energy-label.png" alt="Energy label A" />Energy label B</span></li>
					<li>Easy to clean and refill</li>
					<li>Taste best tested</li>
					<li>Energy label A</li>
				</ul>
			</div>
		</div>

		<!-- product overview -->
		<div class="row product-filter open">
			
			<div class="col col-6of6">
				<h2><span class="filter-arrow"></span> Choosing your solution by requirements</h2>
				<p>Let us help to find the best suitable coffeemachine for your employees and clients.</p>
			</div>

			<div class="product-filter-options">
				<div class="col col-2of6 fieldset-cols">
					<fieldset>
						<h3>Desired hot drinks varieties</h3>
						<label><input type="checkbox" /><span></span> Black coffee </label>
						<label><input type="checkbox" /><span></span> Espresso</label>
						<label><input type="checkbox" /><span></span> Cappuchino</label>
						<label><input type="checkbox" /><span></span> Cafe au lait</label>
						<label><input type="checkbox" /><span></span> Hot water</label>
						<label><input type="checkbox" /><span></span> Hot chocolade</label>
						<label><input type="checkbox" /><span></span> Wiener melange</label>
					</fieldset>

					<fieldset>
						<h3>Time available per week to clean a machine?</h3>
						<label><input type="checkbox" /><span></span>0-1 hour</label>
						<label><input type="checkbox" /><span></span> 1-2 hours</label>
						<label><input type="checkbox" /><span></span> 2-3 hours</label>
						<label><input type="checkbox" /><span></span> 3 hours +</label>
					</fieldset>
				</div>
				<div class="col col-2of6">
					<fieldset>
						<h3>What environment do you want to use the machine?</h3>
						<label><input type="checkbox" /><span></span> Lobby / reception desk</label>
						<label><input type="checkbox" /><span></span> Factory floor / workshop</label>
						<label><input type="checkbox" /><span></span> Small shop / snackbar</label>
						<label><input type="checkbox" /><span></span> Meeting room</label>
						<label><input type="checkbox" /><span></span> Kitchen / catering facility</label>
						<label><input type="checkbox" /><span></span> Vending environment</label>
						<label><input type="checkbox" /><span></span> Coffee corner</label>
						<label><input type="checkbox" /><span></span> Office</label>
					</fieldset>
				</div>
				<div class="col col-2of6">
					<fieldset>
						<h3>In what situation do you want to use the machine?</h3>
						<label><input type="checkbox" /><span></span> Very high volumes in short time spans</label>
						<label><input type="checkbox" /><span></span> Constant heavy use with peaks</label>
						<label><input type="checkbox" /><span></span> Constant even use throughout the day</label>
						<label><input type="checkbox" /><span></span> Use by catering staff</label>
						<label><input type="checkbox" /><span></span> Use by custommers & personel</label>
					</fieldset>

					<fieldset class="buttons">
						<a class="button" href="">Show<span><span></span></span></a>
						<a href="">Reset filter</a>
					</fieldset>
				</div>
			</div>
		</div>
	
		<!-- no resultaat -->
		<div class="row">
			<div class="col col-6of6">
				No results were found with the selected criteria
			</div>
		</div>

		<div class="product-toolbox">
			<h4>Selected coffee machines:</h4>
			<ul></ul>
			<a href="" class="button">Compare<span><span></span></span></a>
		</div>

		<!-- 
			product-list with class border-curved for seperation 
			each row can contain 4 products
		-->
		<div class="row product-list border-curved">
			<div class="col col-1-5of6">
				<div class="product">
					<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
					<h3>Cafitesse Excellence</h3>
					<p>Biedt u de unieke combinatie van een prachtig vormgegeven m...</p>
					<label><input type="checkbox" /><span></span> Compare</label>
					<a class="button" href="">Details<span><span></span></span></a>
				</div>
			</div>
			<div class="col col-1-5of6">
				<div class="product">
					<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
					<h3>Cafitesse 50</h3>
					<p>Biedt u de unieke combinatie van een prachtig vormgegeven m...</p>
					<label><input type="checkbox" /><span></span> Compare</label>
					<a class="button" href="">Details<span><span></span></span></a>
				</div>
			</div>
			<div class="col col-1-5of6">
				<div class="product">
					<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
					<h3>Cafitesse 60</h3>
					<p>Biedt u de unieke combinatie van een prachtig vormgegeven m...</p>
					<label><input type="checkbox" /><span></span> Compare</label>
					<a class="button" href="">Details<span><span></span></span></a>
				</div>
			</div>
			<div class="col col-1-5of6">
				<div class="product">
					<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
					<h3>Cafitesse NG 100</h3>
					<p>Biedt u de unieke combinatie van een prachtig vormgegeven m...</p>
					<label><input type="checkbox" /><span></span> Compare</label>
					<a class="button" href="">Details<span><span></span></span></a>
				</div>
			</div>
		</div>

		<!-- second product-list, without border-curved since it's the last row -->
		<div class="product-list row">
			<div class="col col-1-5of6">
				<div class="product">
					<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
					<h3>Cafitesse 2100</h3>
					<p>Biedt u de unieke combinatie van een prachtig vormgegeven m...</p>
					<label><input type="checkbox" /><span></span> Compare</label>
					<a class="button" href="">Details<span><span></span></span></a>
				</div>
			</div>
			<div class="col col-1-5of6">
				<div class="product">
					<img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png" alt="" />
					<h3>Schaerer Coffee Art Plus</h3>
					<p>Biedt u de unieke combinatie van een prachtig vormgegeven m...</p>
					<label><input type="checkbox" /><span></span> Compare</label>
					<a class="button" href="">Details<span><span></span></span></a>
				</div>
			</div>
		</div>

		<!-- call to actions -->
		<div class="col-wrapper col-box call-to-action">
			<em>Contact us for personal coffee advice</em>	
			<div class="call-button-holder">
				<a href="tel:0302312108" class="call-link">030 23 12 108<span></span></a> <span>or</span> <a class="button button-yellow">Call me back <span><span></span></span></a>
			</div>
		</div>

		<div class="col-wrapper">
			<div class="col col-3of6">
				f101
			</div>
			<div class="col col-3of6 call-to-action">
				<em>Get</em>	
				<div class="call-button-holder">
					<a href="tel:0302312108" class="call-link">030 23 12 108<span></span></a> <span>or</span> <a class="button button-yellow">Call me back <span><span></span></span></a>
				</div>
			</div>
		</div>
		
		<!-- overview of people -->
		<div class="col-wrapper col-box">
			<ul class="nav clearfix overview">
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual-100x104.jpg" alt="" /></a>
					<div>
						<h2>Chris baker</h2>
						<p>Specialist in hospitals, clinics, health and care segment</p>
						<a href="" class="readmore">Meet Chris</a>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual-100x104.jpg" alt="" /></a>
					<div>
						<h2>Chris baker</h2>
						<p>Specialist in hospitals, clinics, health and care segment asdf haklsdh fks fkasd fkldh fklasd fklsdh fklash fasdkh flaskf sklh alsfasdlfkjash lkjh asdf asdf asdf sf asf asdfhasdk fsklf asklh fklsh fiasd fask ak fhf asklf kla akl kh fklahf askfh lkh kljh </p>
						<a href="" class="readmore">Meet Chris</a>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual-100x104.jpg" alt="" /></a>
					<div>
						<h2>Chris baker</h2>
						<p>Specialist in hospitals, clinics, health and care segment asdf haklsdh fks fkasd fkldh fklasd fklsdh fklash fasdkh flaskf sklh alsfasdlfkjash lkjh asdf asdf asdf sf asf asdfhasdk fsklf asklh fklsh fiasd fask ak fhf asklf kla akl kh fklahf askfh lkh kljh </p>
						<a href="" class="readmore">Meet Chris</a>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual-100x104.jpg" alt="" /></a>
					<div>
						<h2>Chris baker</h2>
						<p>Specialist in hospitals, clinics, health and care segment</p>
						<a href="" class="readmore">Meet Chris</a>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual-100x104.jpg" alt="" /></a>
					<div>
						<h2>Chris baker</h2>
						<p>Specialist in hospitals, clinics, health and care segment</p>
						<a href="" class="readmore">Meet Chris</a>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual-100x104.jpg" alt="" /></a>
					<div>
						<h2>Chris baker</h2>
						<p>Specialist in hospitals, clinics, health and care segment</p>
						<a href="" class="readmore">Meet Chris</a>
					</div>
				</li>
			</ul>
		</div>

		<!-- tabs -->
		<div class="row">
			<div class="machine-properties-holder">
				<div class="tabs-holder">
					<ul class="nav tabs clearfix">
						<li><a href="#description">Description</a></li>
						<li><a href="#specifications">Specifications</a></li>
						<li><a href="#media">Photo's &amp; video's</a></li>
						<li><a href="#faq">Faq</a></li>
					</ul>
					<div id="description">
						<h2>Excellent taste, honest coffee</h2>
						<p>Sustainable and pure coffee without waiting. That’s the big advantage of the Caffitesse coffee machine. All our products are manufactured through sustainable cultivation, so you get an honest and fresh product at top speed.</p>
						<hr />

						<h2>Excellent taste, honest coffee</h2>
						<p>Sustainable and pure coffee without waiting. That’s the big advantage of the Caffitesse coffee machine. All our products are manufactured through sustainable cultivation, so you get an honest and fresh product at top speed.</p>
						<hr />

						<h2>Excellent taste, honest coffee</h2>
						<p>Sustainable and pure coffee without waiting. That’s the big advantage of the Caffitesse coffee machine. All our products are manufactured through sustainable cultivation, so you get an honest and fresh product at top speed.</p>
						<hr />

						<h2>Excellent taste, honest coffee</h2>
						<p>Sustainable and pure coffee without waiting. That’s the big advantage of the Caffitesse coffee machine. All our products are manufactured through sustainable cultivation, so you get an honest and fresh product at top speed.</p>

						<div class="tab-nav">
							<a href="" class="readmore">Product specification</a>
						</div>
					</div>
					<div id="specifications">
						<table class="specifications">
							<tr>
								<td colspan="2">
									<h3>Hihglights</h3>
									<ul class="clearfix highlights">
										<li>
											<strong>1,25</strong>
											<dfn>Contents</dfn>
											<em>liter</em>
										</li>
										<li>
											<strong>140</strong>
											<dfn>Capacity</dfn>
											<em>cups / hour</em>
										</li>
										<li>
											<strong class="small">50-100</strong>
											<dfn>Range</dfn>
											<em>liter</em>
										</li>
										<li>
											<strong>36</strong>
											<dfn>Weight</dfn>
											<em>kg (empty)</em>
										</li>
									</ul>
								</td>
							</tr>
							<tr>
								<th>Varities <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>
									<ul class="nav varities">
										<li>Coffee</li>
										<li>Cappucino</li>
										<li>Decafe</li>
										<li>Espresso</li>
										<li>Hot water</li>
										<li>Cafe au lait</li>
									</ul>
								</td>
							</tr>
							<tr>
								<th>Capacity <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>140 cups / hour <br />51 - 100 users</td>
							</tr>
							<tr>
								<th>Performance <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>Very high volumes in short time spans<br />constant heavy use with peaks</td>
							</tr>
							<tr>
								<th>contains / storage <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>
									140 cups / hour
									<br />51 &ndash; 100 users
								</td>
							</tr>
							<tr>
								<th>Performance <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>
									Very high volumes in short time spans
									<br />Constant heavy use with peaks
								</td>
							</tr>
							<tr>
								<th>Contains / storage</th>
								<td>1,25 liter</td>
							</tr>
							<tr>
								<th>conditions</th>
								<td>
									6 wks in machines refridgerator
									<br />1 year at &ndash; 18C in freezer
								</td>
							</tr>
							<tr>
								<th>
									Energy label / energy
									<br />useage power
								</th>
								<td>
									<span class="energy-label energy-label-f"><img src="<?= bloginfo('template_url') ?>/img/spr-energy-label.png" alt="Energy label F" /></span> 4,2 KWh / 220 - 230 Volt
								</td>
							</tr>
							<tr>
								<th>Weight (empty) in operation</th>
								<td>27 kg / 35 kg</td>
							</tr>
							<tr>
								<th>Dimensions (HxWxD)</th>
								<td>715 x 420 x 400 mm</td>
							</tr>
							<tr>
								<th>Water container</th>
								<td>2.9 liter</td>
							</tr>
							<tr>
								<th>Water supply <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>Yes</td>
							</tr>
							<tr>
								<th>Cleaning time <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>20 minutes</td>
							</tr>
							<tr>
								<th>Idealy used in <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td>
									Office
									<br />Lobby / Reception desk
									<Br />Factory floor / Workshop
								</td>
							</tr>
							<tr>
								<th>Price indication <a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a></th>
								<td><span class="indicator indicator-2"><img src="<?= bloginfo('template_url') ?>/img/spr-indicator.png" alt="" /></span></td>
							</tr>
						</table>
						<div class="tab-nav">
							<a href="" class="return">Description</a>
							<a href="" class="readmore">Photos and video's</a>
						</div>
					</div>
					<div id="media">
						<ul class="nav clearfix media">
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<!-- use video-thumb class to indicate a video link -->
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540" class="video-thumb"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /><span></span></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
						</ul>
						<div class="tab-nav">
							<a href="" class="return">Specifications</a>
							<a href="" class="readmore">Frequently asked questions</a>
						</div>
					</div>
					<div id="faq">
						<ol class="faq">
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
						</ol>

						<h2>Your question not in the list?</h2>
						<a href="" class="button"><span><span></span></span>Ask us</a>

						<div class="tab-nav">
							<a href="" class="return">Photo's and video's</a>
						</div>
					</div>
				</div>
				<div class="tab-bottom clearfix">
					<div class="tab-bottom-left call-to-action">
						<h2>Interested?</h2>
						<a href="" class="button"><span><span></span></span>Quote</a>
						<br /><a href="" class="button button-yellow"><span><span></span></span>Trial</a>
						<br /><a href="" class="button button-yellow"><span><span></span></span>Call me back</a>
					</div>
					<div class="tab-bottom-right">
						<h2>Downloads</h2>
						<ul class="nav downloads">
							<li><a href="" class="pdf"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
							<li><a href="" class="doc"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
							<li><a href="" class="img"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
							<li><a href="" class="ppt"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col col-2of6">
				<div class="row">
					<h3>Service concepts</h3>

					<p>Douwe Egberts Coffee System is driven to continuously innovate its products and knowledge to offer its customers the best possible solution.</p>

					<a href="" class="readmore">More about service concept</a>
				</div>
				<div class="row">
					<h3>Service concepts</h3>

					<p>Douwe Egberts Coffee System is driven to continuously innovate its products and knowledge to offer its customers the best possible solution.</p>

					<a href="" class="readmore">More about service concept</a>
				</div>
				<div class="row">
					<h3>Service concepts</h3>

					<p>Douwe Egberts Coffee System is driven to continuously innovate its products and knowledge to offer its customers the best possible solution.</p>

					<a href="" class="readmore">More about service concept</a>
				</div>
			</div>
		</div>

		<!-- 
			Carousel with compare function 
			remove the 'carousel-compare' class to have a carousel with compare functionality
		-->

		<div class="col-wrapper col-box carousel carousel-compare">
			<a class="prev"></a>
			<a class="next"></a>

			<div class="viewport">
				<div class="row">
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
					<div class="col col-2of6">
						<a href=""><img alt="" src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_3100_108x108.png"></a>
						<h3><a href="">Cafitesse Excellence</a></h3>
						<label>
							<input type="checkbox"><span></span> 
							<span class="label">Compare</span>
							<a href="" class="button"><span><span></span></span>Compare</a>
						</label>
					</div>
				</div>
			</div>
		</div> 

		<!-- Product category overview -->
		<div class="col-wrapper col-box">
			<h1>Discover our products</h1>

			<ul class="nav product-category-overview clearfix">
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual1-132x132.jpg" alt="" /></a>
					<div class="product-category-links">
						<h2><a href="">Coffee</a></h2>
						<ul>
							<li><a href="">Senseo</a></li>
							<li><a href="">Espresso</a></li>
							<li><a href="">Fresh Brew</a></li>
							<li><a href="">Filter</a></li>
							<li><a href="">Cafitesse</a></li>
							<li><a href="">instant</a></li>
							<li><a href="">nog een link</a></li>
							<li><a href="">en nog wat</a></li>
							<li><a href="">en een tje die over 2 regels gaat want die is heel lang en zo</a></li>
							<li><a href="">asdf asf asdf </a></li>
							<li><a href=""> sdf df</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /></a>
					<div class="product-category-links">
						<h2><a href="">Tea</a></h2>
						<ul>
							<li><a href="">Senseo</a></li>
							<li><a href="">Espresso</a></li>
							<li><a href="">Fresh Brew</a></li>
							<li><a href="">Filter</a></li>
							<li><a href="">Cafitesse</a></li>
							<li><a href="">instant</a></li>
							<li><a href="">nog een link</a></li>
							<li><a href="">en nog wat</a></li>
							<li><a href="">en een tje die over 2 regels gaat want die is heel lang en zo</a></li>
							<li><a href="">asdf asf asdf </a></li>
							<li><a href=""> sdf df</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual3-132x132.jpg" alt="" /></a>
					<div class="product-category-links">
						<h2><a href="">Aqa</a></h2>
						<ul>
							<li><a href="">Senseo</a></li>
							<li><a href="">Espresso</a></li>
							<li><a href="">Fresh Brew</a></li>
							<li><a href="">Filter</a></li>
							<li><a href="">Cafitesse</a></li>
							<li><a href="">instant</a></li>
							<li><a href="">nog een link</a></li>
							<li><a href="">en nog wat</a></li>
							<li><a href="">en een tje die over 2 regels gaat want die is heel lang en zo</a></li>
							<li><a href="">asdf asf asdf </a></li>
							<li><a href=""> sdf df</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual4-132x132.jpg" alt="" /></a>
					<div class="product-category-links">
						<h2><a href="">Cacao</a></h2>
						<ul>
							<li><a href="">Senseo</a></li>
							<li><a href="">nog een link</a></li>
							<li><a href=""> sdf df</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual5-132x132.jpg" alt="" /></a>
					<div class="product-category-links">
						<h2><a href="">Other products</a></h2>
						<ul>
							<li><a href="">Senseo</a></li>
							<li><a href="">Espresso</a></li>
							<li><a href="">Fresh Brew</a></li>
							<li><a href="">Filter</a></li>
							<li><a href="">Cafitesse</a></li>
							<li><a href="">instant</a></li>
							<li><a href="">nog een link</a></li>
							<li><a href="">en nog wat</a></li>
							<li><a href="">en een tje die over 2 regels gaat want die is heel lang en zo</a></li>
							<li><a href="">asdf asf asdf </a></li>
							<li><a href=""> sdf df</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>


		<!-- Coffee machines overview with different content in rows undearneath-->
		<div class="col-wrapper col-box">			
			<div class="row">
				<div class="coffee-machines-overview text-center">
					<div class="col col-1of6">
						<a href="http://decs.saralee.framework.localhost.efocus.local/nl-BE/Belgie/Coffee-machines/Cafitesse/">
							<img alt="Cafitesse" src="<?= bloginfo('template_url') ?>/img/temp/visual1-132x132.jpg">
		        				Cafitesse
						</a>
					</div>
					<div class="col col-1of6">
						<a href="http://decs.saralee.framework.localhost.efocus.local/nl-BE/Belgie/Coffee-machines/Machine-category-name-4/">
							<img alt="Fresh, Brew &amp; Filter" src="<?= bloginfo('template_url') ?>/img/temp/visual1-132x132.jpg">
		        				Fresh, Brew &amp; Filter
						</a>
					</div>
					<div class="col col-1of6">
						<a href="http://decs.saralee.framework.localhost.efocus.local/nl-BE/Belgie/Coffee-machines/Instant/">
							<img alt="Instant" src="<?= bloginfo('template_url') ?>/img/temp/visual1-132x132.jpg">
		        				Instant
						</a>
					</div>
					<div class="col col-1of6">
						<a href="http://decs.saralee.framework.localhost.efocus.local/nl-BE/Belgie/Coffee-machines/Machine-category-name-3/">
							<img alt="Espresso" src="<?= bloginfo('template_url') ?>/img/temp/visual1-132x132.jpg">
		        				Espresso
						</a>
					</div>
					<div class="col col-1of6">
						<a href="http://decs.saralee.framework.localhost.efocus.local/nl-BE/Belgie/Coffee-machines/Machine-category-name-3/">
							<img alt="Espresso" src="<?= bloginfo('template_url') ?>/img/temp/visual1-132x132.jpg">
		        				Espresso
						</a>
					</div>
				</div>

				<div class="col col-1of6 call-to-action">
        			<em>Neem contact op</em>    
	    			<div class="call-button-holder">
						<p>Vragen? Neem contact op via het klantencentrum: <a class="readmore">Read more link</a></p>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col col-2of6">
					<ul class="faq-teaser clearfix">
						<li><a href="">Which coffee concepts do you sell?</a></li>
						<li><a href="">Which brands do you sell?</a></li>
						<li><a href="">What is a coffee concept?</a></li>
						<li><a href="">How big is Douwe Egberts in coffee? en nog eentje die over 2r</a></li>
						<li><a href="">About our machines</a></li>
					</ul>

					<a class="readmore">All frequently asked questions</a>
				</div>

				<div class="col col-2of6 teaser-support">
					<h2>Need a refill?</h2>
					<p>Contact your nearest dealer:</p>
					<a href="" class="button button-yellow"><span><span></span></span>Find dealer</a>
					<br /><a href="tel:030 23 12 108" class="call-link">030 23 12 108 <span></span></a>
				</div>

				<div class="col col-2of6">
					<a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual-250x253.png" alt="" /></a>
				</div>
			</div>

			<div class="row">
				<div class="col col-2of6">
					<h2>Related products</h2>
					<ul class="faq-teaser clearfix">
						<li><a href="" class="readmore">Cafitesse Medium Roast</a></li>
						<li><a href="" class="readmore">Cafitesse Decaffeinated</a></li>
						<li><a href="" class="readmore">Cafitesse Good Origin</a></li>
						<li><a href="" class="readmore">Cacao Fantasy</a></li>
						<li><a href="" class="readmore">Cafitesse Excellence</a></li>
					</ul>
					<a class="readmore">Alle Cafitesse varieties</a>
				</div>
			</div>

			<!-- label green within a image -->
			<div class="row full-image">
				<img src="<?= bloginfo('template_url') ?>/img/temp/visual_1_900x507.jpg" alt="" />
				<p class="label-green">The right blend for hard work </p>		
			</div>
		</div>
		
		<div class="col-wrapper">
			<div class="col col-6of6">
				<h1>FAQ</h1>
			</div>
		</div>
		
		<div class="col-wrapper col-box">
			<div class="row">
				<div class="col col-4of6">
					<h2>Themes</h2>
					<ul class="faq-teaser clearfix">
						<li><a href="">Which coffee concepts do you sell?</a></li>
						<li><a href="">Which brands do you sell? asdf asdf asd fas fasdf</a></li>
						<li><a href="">How big is Douwe Egberts in coffee? en nog eentje die over 2r</a></li>
						<li><a href="">What is a coffee concept?</a></li>						
						<li><a href="">About our machines</a></li>
					</ul>
				</div>
				<div class="col col-2of6">
					Call to action
				</div>
			</div>
		</div>

		<div class="col-wrapper heading-underline faq-overview">
			<div class="row">
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-wrapper col-box">
			<div class="row">
				<div class="col col-6of6">
					<h2>Answer</h2>
					<p>A coffee concept is an integrated offer of ingredients, coffee machines, accesoires, service and training. We customize concepts to your needs. We have different kind of coffee concepts, for specific branches, best practice concepts and advice, but also brand concepts or service concepts.</p>

					<h2>Coffee concept for branches</h2>
					<ul class="faq-teaser clearfix">
						<li><a href="">Which coffee concepts do you sell?</a></li>
						<li><a href="">Which brands do you sell? asdf asdf asd fas fasdf</a></li>
						<li><a href="">How big is Douwe Egberts in coffee? en nog eentje die over 2r</a></li>
						<li><a href="">What is a coffee concept?</a></li>
						<li><a href="">About our machines</a></li>
						<li><a href="">Which coffee concepts do you sell?</a></li>
						<li><a href="">Which brands do you sell? asdf asdf asd fas fasdf</a></li>
						<li><a href="">How big is Douwe Egberts in coffee? en nog eentje die over 2r</a></li>
						<li><a href="">What is a coffee concept?</a></li>
						<li><a href="">About our machines</a></li>
					</ul>
				</div>
			</div>
		</div>

		<!-- FAQ -->
		<div class="col-wrapper heading-underline faq-overview">
			<div class="row nomargin">
				<div class="col col-6of6">
					<span>More FAQ in:</span>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
				<div class="col col-2of6">
					<h2>About our machines</h2>
					<ul class="nav">
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Hoeveel tijd neemt de verzorging van een koffie machine in beslag?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
						<li><a href="">Wat is de levertijd op machines?</a></li>
					</ul>
				</div>
			</div>

			<div class="row">
				<div class="col col-6of6">
					<a href="" class="return">Back to frequently asked questions</a>
				</div>
			</div>
		</div>

		<!-- product highlight -->
		<div class="col-wrapper col-box">
			<div class="row product-highlight border-curved">
				<div class="col col-2of6">
					<img src="<?= bloginfo('template_url') ?>/img/temp/visual-252x277.png" alt="" />
				</div>
				<div class="col col-4of6">
					<h2>The best selling coffee machine of 2011</h2>
					<p class="intro">Unlike most coffee machines the Caffitesse combines speed with a delicious and honest cup of coffee. Find out which machine fits your companies’ wishes, so you can drink a fast en freshly brewed coffee every day.</p>
					<a href="" class="readmore">More about this machine</a>
				</div>
			</div>
			<div class="row text-center child-pages">
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual-108x108.jpg" alt="Bareca">
						Bareca
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual2-108x108.jpg" alt="Health &amp; care">
						Health &amp; care
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual3-108x108.jpg" alt="Hotels">
						hotels
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual-108x108.jpg" alt="Bareca">
						Bareca
					</a>
				</div>
				<div class="col col-1of6">
					<a href="">
						<img src="<?= bloginfo('template_url') ?>/img/temp/visual2-108x108.jpg" alt="Health &amp; care">
						Health &amp; care
					</a>
				</div>
				<div class="col col-1of6">
					<ul class="nav other-segments">
						<li><a href="">BaReCa</a></li>
						<li><a href="">Hotels</a></li>
						<li><a href="">Medium business</a></li>
						<li><a href="">Big business</a></li>
					</ul>
					<a href="">
						hotels
					</a>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col col-6of6 border-curved">
					<a href="" class="button button-yellow"><span><span></span></span> Meet our specialists</a>
				</div>
			</div>
		</div>

		<div class="col-wrapper col-box">
			<div class="row text-center">
				<div class="col col-6of6">
					<a href="carousel-product.html" rel="shadowbox; width=510;height=540">F132 lightbox</a>
				</div>
			</div>
		</div>

		<div class="col-wrapper">
			<div class="row">
				<div class="col col-6of6">
					<h2>Our broad experience for our clients</h2>
					<p>Besides quality coffee and coffee machines we can deliver axcellent services due to our legacy in the coffee market. 
					As a client we offer you our advice and services to facilitate you with the best in class coffee solutions.</p>
					<a href="" class="readmore">Read more on our services</a>
					
					<hr class="curved" />

					<h3>Back to</h3>
					<ul class="list-style-none">
						<li><a href="" class="readmore">Homepage</a></li>
						<li><a href="" class="readmore">Contact</a></li>
					</ul>
				</div>
			</div>
			
			<!-- dealer contacts -->
			<div class="row">
				<div class="col col-3of6">
					form f302
				</div>
				<div class="col col-3of6">
					<h2>Our dealers</h2>
					<ul class="nav dealer-contacts">
						<li>
							<h3>N.V. Douwe egberts Coffee Systems S.A.</h3>
							<address>
								<div class="floatright">
									T. +32 2 260 06 11
									<br />F. +32 2 260 06 12
									<br />E. <a href="mailto:info@decs.be">info@decs.be</a>
								</div>

								<div>
									Potaarde 8800/Z
									<br />1850 Grimbergen
									<br />België
								</div>
							</address>
						</li>
						<li>
							<h3>N.V. Douwe egberts Coffee Systems S.A.</h3>
							<address>
								<div class="floatright">
									T. +32 2 260 06 11
									<br />F. +32 2 260 06 12
									<br />E. <a href="mailto:info@decs.be">info@decs.be</a>
								</div>

								<div>
									Potaarde 8800/Z
									<br />1850 Grimbergen
									<br />België
								</div>
							</address>
						</li>
						<li>
							<h3>N.V. Douwe egberts Coffee Systems S.A.</h3>
							<address>
								<div class="floatright">
									T. +32 2 260 06 11
									<br />F. +32 2 260 06 12
									<br />E. <a href="mailto:info@decs.be">info@decs.be</a>
								</div>

								<div>
									Potaarde 8800/Z
									<br />1850 Grimbergen
									<br />België
								</div>
							</address>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-wrapper col-box product-highlight">
			<div class="row">
				<div class="col col-2of6">
					<img src="<?= bloginfo('template_url') ?>/img/temp/visual-252x277.png" alt="" />
				</div>
				<div class="col col-4of6">
					<h2>The best selling coffee machine of 2011</h2>
					<p class="intro">Unlike most coffee machines the Caffitesse combines speed with a delicious and honest cup of coffee. Find out which machine fits your companies’ wishes, so you can drink a fast en freshly brewed coffee every day.</p>

					<a href="" class="readmore">More about this machine</a>
				</div>
			</div>
		</div>

		<!-- confirmation highlights -->
		<div class="col-wrapper">
			<div class="row">
				<div class="col col-6of6">
					<ul class="nav confirmation-highlights clearfix">
						<li>
							<img src="<?= bloginfo('template_url') ?>/img/temp/icon-46x46.png" alt="" />
							<h3>Sustainable coffee solution</h3>
							<a href="" class="readmore">More about sustainable coffee</a>
						</li>
						<li>
							<img src="<?= bloginfo('template_url') ?>/img/temp/icon2-46x46.png" alt="" />
							<h3>Sustainable coffee solution</h3>
							<a href="" class="readmore">More about sustainable coffee</a>
						</li>
						<li>
							<img src="<?= bloginfo('template_url') ?>/img/temp/icon-46x46.png" alt="" />
							<h3>Sustainable coffee solution</h3>
							<a href="" class="readmore">More about sustainable coffee</a>
						</li>
						<li>
							<img src="<?= bloginfo('template_url') ?>/img/temp/icon-46x46.png" alt="" />
							<h3>Energy efficient machinery, saves money on your electric bill</h3>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- product images overview -->
		<div class="col-wrapper col-box">
			<div class="row">
				<div class="col col-6of6">
					<h2>Our products for</h2>
					<ul class="nav product-images-overview clearfix">
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Senseo</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Espresso</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Fresh brew</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Filter</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Cafitesse</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Isntant</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Isntant</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Isntant</h3></a></li>
						<li><a href=""><img src="<?= bloginfo('template_url') ?>/img/temp/visual2-132x132.jpg" alt="" /><h3>Isntant</h3></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- location -->
    <div class="col-wrapper">
        <div class="row nomargin location heading-underline">
        	<img class="logo-location" alt="" src="<?= bloginfo('template_url') ?>/img/temp/logo-beeldmerk.png">
        	<div class="col col-2of6">
        		 <label class="label-location">
	        		<input type="checkbox">
	        		<span></span>
	        		Remember my choice for next time
        		</label>
        		<h2>Nort America</h2>
        		<ul class="nav location">
        			<li><a href="#">Canada (English)</a></li>
        			<li><a href="#">Canada (Français)</a></li>
        			<li><a href="#">United states</a></li>
        		</ul>
        		<h2>Latin America</h2>
        		<ul class="nav location">
        			<li><a href="#">Argentina</a></li>
        			<li><a href="#">Brasil</a></li>
        			<li><a href="#">Chile</a></li>
        			<li><a href="#">Mexico</a></li>
        			<li><a href="#">Peru</a></li>
        			<li><a href="#">Venezuela</a></li>
        		</ul>
        		<h2>Middle East &amp; Africa</h2>
        		<ul class="nav location">
        			<li><a href="#">Argentina</a></li>
        			<li><a href="#">Brasil</a></li>
        			<li><a href="#">Chile</a></li>
        			<li><a href="#">Central america</a></li>
        			<li><a href="#">Colombia</a></li>
        			<li><a href="#">Mexico</a></li>
        			<li><a href="#">Peru</a></li>
        			<li><a href="#">Uruguay</a></li>
        			<li><a href="#">Venezuela</a></li>
        		</ul>
        	</div>
        	<div class="col col-2of6">
        		<h2>Europe</h2>
        		<ul class="nav location">
        			<li><a href="#">België (Nederlands)</a></li>
        			<li><a href="#">Belgique (Français)</a></li>
        			<li><a href="#">България</a></li>
        			<li><a href="#">Cyprus</a></li>
        			<li><a href="#">Česká republika</a></li>
        			<li><a href="#">Danmark</a></li>
        			<li><a href="#">Deutschland</a></li>
        			<li><a href="#">France</a></li>
        			<li><a href="#">Ελλάδα</a></li>
        			<li><a href="#">Hrvatska</a></li>
        			<li><a href="#">Ireland</a></li>
        			<li><a href="#">Italia</a></li>
        			<li><a href="#">Luxembourg (Français)</a></li>
        			<li><a href="#">Macedonia</a></li>
        			<li><a href="#">Magyarország</a></li>
        		</ul>
        	</div>
        	<div class="col col-2of6">
        		<h2>Asia pacific</h2>
        		<ul class="nav location">
        			<li><a href="#">Australia</a></li>
        			<li><a href="#">China</a></li>
        			<li><a href="#">Indonesia</a></li>
        			<li><a href="#">India</a></li>
        			<li><a href="#">New Zealand</a></li>
        		</ul>
        		<h2>Global</h2>
        		<ul class="nav location">
        			<li><a href="#">Global site (English)</a></li>
        		</ul>
        	</div>
        </div>
    </div>


	<!-- comparison tool -->
    <div class="col-wrapper compare-nav">
    	<div class="row nomargin">
			<a href="#">Start over</a>
			<div class="comparison-button-holder">
				<a class="print-link" href="">print this comparison<span></span></a>
				<a class="comparison-button-holder share-link" href="">Share this comparison<span></span></a>
			</div>
    	</div>
    </div>

	<div class="col-wrapper">
		<div class="col col-6of6">
			<div class="row nomargin">
				<a class="return" href="">Back to previous page</a>
			</div>
		</div>
		<div class="col col-3of6">
			<h1>Compare 2 machines</h1>
		</div>
	</div>

	<div class="col-wrapper compare-nav">
		<div class="row nomargin">
			<a href="">Start over</a>
			<div class="comparison-button-holder">
				<a href="" class="print-link">
					Print this comparison
					<span></span>
				</a>
			</div>
		</div>
	</div>

	<div data-decs-machinecount="2" class="col-wrapper col-box compare-machines" id="comparisonTool">
		<div class="col col-2of6">
			<div class="machine-name">.
				<a href="" class="close-button"></a>
				<h2>Cafitesse 2100</h2>
			</div>
			<div class="machine-details-holder">
				<div class="machine-intro">
					<a rel="shadowbox; width=510;height=540" href="carousel-product.html">
						<img alt="Cafitesse 2100" src="<?= bloginfo('template_url') ?>/img/temp/visual-108x108.jpg"></a>
					<h2>Maximum coffee variation</h2>
				</div>

				<a class="button" href="">
					<span>
						<span></span>
					</span>
					More details
				</a>

				<ul class="machine-details">
					<li>
						<h3>Variations</h3>
						<ul class="split-list">
							<li>Coffee with milk and sugar</li>
							<li>Espresso</li>
							<li>Espresso with milk and sugar</li>
							<li>Cappuccino with sugar</li>
							<li>Cappuccino</li>
							<li>Cafe creme</li>
							<li>Cafe au lait</li>
							<li>Decaffeinated</li>
							<li>Latte macchiato</li>
							<li>Wiener melange</li>
							<li>Cafe choco</li>
							<li>Hot water</li>
							<li>Cold water</li>
							<li>Tea</li>
							<li>Tea with milk and sugar</li>
							<li>Chocolate</li>
							<li>Choco de luxe</li>
							<li>Soup</li>
						</ul>
					</li>
					<li>
						<h3>Capacity</h3>
						<ul>
							<li>225&nbsp;cups / hour</li>
							<li hidden="hidden">0&nbsp;Cups in machine</li>
						</ul>
					</li>

					<li>
						<h3>Contains / Conditions</h3>
						<ul class="split-list">
							<li>Coffee: 4&nbsp;Liter</li>
							<li>Coffee: 0&nbsp;Kg</li>
							<li>Decaf: 0&nbsp;Liter</li>
							<li>Decaf: 0&nbsp;Kg</li>
							<li>Cocoa: 0&nbsp;Liter</li>
							<li>Cocoa: 2.6&nbsp;Kg</li>
							<li>Milk: 0&nbsp;Liter</li>
							<li>Milk: 1.5&nbsp;Kg</li>
							<li>Sugar: 0&nbsp;Liter</li>
							<li>Sugar: 3.1&nbsp;Kg</li>
							<li>Storage conditions: Coffee; 6 weeks in the cooling of the machine, 1 year at -18°C in freezer.</li>
						</ul>
					</li>
					<li>
						<h3>Power Usage</h3>
						<span>0&nbsp;KWh /</span>
						<span>230 - 230&nbsp;Volt</span>
					</li>
					<li>
						<h3>
							<span>Electricity /</span>
							<span>Power in Watt</span>
						</h3>
						<span>13&nbsp;Volt/</span>
						<span>3000&nbsp;Power in Watt</span>
					</li>
					<li>
						<h3>Weight empty</h3>
						<span>89&nbsp;Kg</span>
					</li>
					<li>
						<h3>Dimensions (HxWxD)</h3>
						940x540x594&nbsp;mm
					</li>
					<li>
						<h3>
							<span>Reservoir /</span>
							<span>Water supply</span>
						</h3>
						<span>0&nbsp;Liter /</span>
						<span>yes</span>
					</li>

					<li data-value="none">
						<h3>Segment</h3>
						<ul class="split-list">
							<li>-</li>
						</ul>
					</li>
					<li>
						<h3>Payment system</h3>
						<ul class="split-list">
							<li>Coin mechanism</li>
							<li>Chipknip</li>
							<li>Card system</li>
							<li>Preferred payment</li>
						</ul>
					</li>
					<li>
						<h3>Production rate</h3>
						<span>9 seconds per cup, 60 seconds per can</span>
					</li>
				</ul>
			</div>
		</div>

		<div class="col col-2of6">
			<div class="machine-name">
				<a href="" class="close-button"></a>
				<h2>Cafitesse 50</h2>
			</div>
			<div class="machine-details-holder">
				<div class="machine-intro">
					<a rel="shadowbox; width=510;height=540" href="">
						<img alt="Cafitesse 50" src="<?= bloginfo('template_url') ?>/img/temp/visual-108x108.jpg"></a>
					<h2>Fast, easy and can be used anywhere</h2>
				</div>

				<a class="button" href="">
					<span>
						<span></span>
					</span>
					More details
				</a>

				<ul class="machine-details">
					<li>
						<ul class="split-list">
							<li>Cafe creme</li>
						</ul>
					</li>
					<li>
						<ul>
							<li>140&nbsp;cups / hour</li>
							<li>0&nbsp;Cups in machine</li>
						</ul>
					</li>
					<li>
						<ul class="split-list">
							<li>Coffee: 1.25&nbsp;Liter</li>
							<li>Coffee: 0&nbsp;Kg</li>
							<li>Decaf: 0&nbsp;Liter</li>
							<li>Decaf: 0&nbsp;Kg</li>
							<li>Cocoa: 0&nbsp;Liter</li>
							<li>Cocoa: 0&nbsp;Kg</li>
							<li>Milk: 0&nbsp;Liter</li>
							<li>Milk: 0&nbsp;Kg</li>
							<li>Sugar: 0&nbsp;Liter</li>
							<li>Sugar: 0&nbsp;Kg</li>
							<li>Storage conditions: Coffee; 6 weeks in the cooling of the machine</li>
						</ul>
					</li>
					<li>
						<span>0&nbsp;KWh /</span>
						<span>230 - 230&nbsp;Volt</span>
					</li>
					<li>
						<span>16&nbsp;Volt /</span>
						<span>2100&nbsp;Power in Watt</span>
					</li>
					<li>
						<span>12&nbsp;Kg</span>
					</li>
					<li>
						560x325x360&nbsp;mm
					</li>
					<li>
						<span>3&nbsp;Liter /</span>
						<span>No</span>
					</li>
					<li>
						<ul class="split-list">
							<li>Small companies</li>
							<li>Medium companies</li>
						</ul>
					</li>
					<li data-value="none">
						<ul class="split-list">
							<li>-</li>
						</ul>
					</li>
					<li>
						<span>7 seconds per cup</span>
					</li>
				</ul>
			</div>

		</div>

		<div class="col col-2of6">
			<div class="machine-name">
				<a class="add-button" href=""></a>
			</div>
			<div class="machine-details-holder">
				<div class="machine-intro">
					<h2>Add a new machine to the selection</h2>
				</div>
			</div>

		</div>

	</div>
<? endif; ?>

<? get_footer() ?>