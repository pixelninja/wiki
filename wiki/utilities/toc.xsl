<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="*" mode="toc" />
	
	<xsl:template match="*[(h2 | h3) and count(*) &gt; 15]" mode="toc">
		<h2>Table of contents</h2>
		
		<ol class="toc">
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
						<xsl:value-of select="." />
					</a>
					
					<xsl:if test="following-sibling::h3">
						<ol>
							<xsl:for-each select="following-sibling::h3[position() &lt; $next]">
								<li>
									<xsl:value-of select="$tocsection" />
									<xsl:text>.</xsl:text>
									<xsl:value-of select="position()" />
									<xsl:text>. </xsl:text>
									
									<a href="#view={$tocsection}.{position()}">
										<xsl:value-of select="." />
									</a>
								</li>
							</xsl:for-each>
						</ol>
					</xsl:if>
				</li>
			</xsl:for-each>
		</ol>
	</xsl:template>
</xsl:stylesheet>