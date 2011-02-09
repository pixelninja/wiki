<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="*" mode="toc" />
	
	<xsl:template match="*[count(h2 | h3) &gt; 3 and count(*) &gt; 9]" mode="toc">
		<h2>Table of contents</h2>
		
		<nav class="contents">
			<ol>
				<xsl:for-each select="h2">
					<xsl:variable name="tocsection" select="position()" />
					<xsl:variable name="next" select="
						1 + count(following-sibling::h3[
							preceding-sibling::h2[1] = current()
						])
					" />
					
					<li>
						<xsl:value-of select="$tocsection" />
						<xsl:text>. </xsl:text>
						
						<a href="#view={$tocsection}">
							<xsl:apply-templates select="node()" mode="output-toc" />
						</a>
						
						<xsl:if test="following-sibling::h3[position() &lt; $next]">
							<ol>
								<xsl:for-each select="following-sibling::h3[position() &lt; $next]">
									<li>
										<xsl:value-of select="$tocsection" />
										<xsl:text>.</xsl:text>
										<xsl:value-of select="position()" />
										<xsl:text>. </xsl:text>
										
										<a href="#view={$tocsection}.{position()}">
											<xsl:apply-templates select="node()" mode="output-toc" />
										</a>
									</li>
								</xsl:for-each>
							</ol>
						</xsl:if>
					</li>
				</xsl:for-each>
			</ol>
		</nav>
	</xsl:template>
	
	<!-- Inline Elements -->
	<xsl:template match="*" mode="output-toc">
		<xsl:element name="{name()}">
			<xsl:apply-templates select="* | @* | text()" mode="output-toc" />
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="a" mode="output-toc" />
	
	<!-- Inline Attributes -->
	<xsl:template match="@*" mode="output-toc">
		<xsl:attribute name="{name()}">
			<xsl:value-of select="." />
		</xsl:attribute>
	</xsl:template>
	
	<!-- Inline Text -->
	<xsl:template match="text()" mode="output-toc">
		<xsl:value-of select="." />
	</xsl:template>
</xsl:stylesheet>