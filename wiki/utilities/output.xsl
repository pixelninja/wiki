<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<!-- Block Elements -->
	<xsl:template match="*" mode="output">
		<xsl:element name="{name()}">
			<xsl:apply-templates select="* | @* | text()" mode="output" />
		</xsl:element>
	</xsl:template>
	
	<!-- Block Attributes -->
	<xsl:template match="@*" mode="output">
		<xsl:attribute name="{name()}">
			<xsl:value-of select="." />
		</xsl:attribute>
	</xsl:template>
	
	<!-- Inline Parents -->
	<xsl:template match="h1|h2|h3|h4|h5|h6" mode="output" priority="1">
		<xsl:variable name="size">
			<xsl:choose>
				<xsl:when test="name() = 'h1'">1</xsl:when>
				<xsl:when test="name() = 'h2'">2</xsl:when>
				<xsl:when test="name() = 'h3'">3</xsl:when>
				<xsl:when test="name() = 'h4'">4</xsl:when>
				<xsl:when test="name() = 'h5'">5</xsl:when>
				<xsl:when test="name() = 'h6'">6</xsl:when>
			</xsl:choose>
		</xsl:variable>
		
		<xsl:if test="$size = 2 and not(preceding-sibling::h2)">
			<xsl:apply-templates select=".." mode="toc" />
		</xsl:if>
		
		<xsl:element name="h{$size}">
			<xsl:attribute name="id">
				<xsl:variable name="position">
					<xsl:number count="h1|h2|h3|h4|h5|h6" />
				</xsl:variable>
			</xsl:attribute>
			
			<xsl:apply-templates select="@*" mode="output-inline" />
			
			<xsl:if test="$size = 2">
				<xsl:variable name="position" select="1 + count(preceding-sibling::h2)" />
				
				<a class="toc" id="section-{$position}" href="#view={$position}">
					<xsl:value-of select="$position" />
					<xsl:text>. </xsl:text>
				</a>
			</xsl:if>
			
			<xsl:if test="$size &gt; 1">
				<a class="top" href="#view">Top</a>
			</xsl:if>
			
			<xsl:if test="$size = 3">
				<xsl:variable name="section" select="preceding-sibling::h2[1]" />
				<xsl:variable name="position" select="count(preceding-sibling::h2)" />
				<xsl:variable name="subposition" select="
					1 + count(preceding-sibling::h3[
						preceding-sibling::h2[1] = $section
					])
				" />
				
				<a class="toc" id="section-{$position}-{$subposition}" href="#view={$position}.{$subposition}">
					<xsl:value-of select="$position" />
					<xsl:text>.</xsl:text>
					<xsl:value-of select="$subposition" />
					<xsl:text>. </xsl:text>
				</a>
			</xsl:if>
			
			<xsl:apply-templates select="* | text()" mode="output-inline" />
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="dt|li|p" mode="output" priority="1">
		<xsl:variable name="name">
			<xsl:value-of select="name()" />
		</xsl:variable>
		
		<xsl:element name="{$name}">
			<xsl:apply-templates select="* | @* | text()" mode="output-inline" />
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="dd" mode="output" priority="1">
		<xsl:variable name="name">
			<xsl:value-of select="name()" />
		</xsl:variable>
		
		<xsl:element name="{$name}">
			<xsl:apply-templates select="* | @* | text()" mode="output" />
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="dd[count(p) = 1]" mode="output" priority="1">
		<xsl:variable name="name">
			<xsl:value-of select="name()" />
		</xsl:variable>
		
		<xsl:element name="{$name}">
			<xsl:apply-templates select="p/* | @* | p/text()" mode="output-inline" />
		</xsl:element>
	</xsl:template>
	
	<!-- Inline Elements -->
	<xsl:template match="*" mode="output-inline">
		<xsl:element name="{name()}">
			<xsl:apply-templates select="* | @* | text()" mode="output-inline" />
		</xsl:element>
	</xsl:template>
	
	<!-- Inline Attributes -->
	<xsl:template match="@*" mode="output-inline">
		<xsl:attribute name="{name()}">
			<xsl:value-of select="." />
		</xsl:attribute>
	</xsl:template>
	
	<xsl:template match="@href" mode="output-inline">
		<xsl:variable name="is-external" select="starts-with(., 'http://') or starts-with(., 'https://')" />
		<xsl:variable name="is-root" select="starts-with(., '/')" />
		<xsl:variable name="is-bookmark" select="starts-with(., '#')" />
		
		<xsl:if test="$is-external">
			<xsl:attribute name='rel'>external</xsl:attribute>
		</xsl:if>
		
		<xsl:attribute name="{name()}">
			<xsl:if test="$is-root">
				<xsl:value-of select="$constants/base-url" />
			</xsl:if>
			
			<xsl:if test="not($is-external or $is-root or $is-bookmark) and $parameters/document-url != ''">
				<xsl:value-of select="$parameters/document-url" />
				<xsl:text>/</xsl:text>
			</xsl:if>
			
			<xsl:value-of select="." />
		</xsl:attribute>
	</xsl:template>
	
	<!-- Inline Text -->
	<xsl:template match="text()" mode="output-inline">
		<xsl:value-of select="." />
	</xsl:template>
</xsl:stylesheet>