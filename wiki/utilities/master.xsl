<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="../utilities/output.xsl" />
	<xsl:import href="../utilities/toc.xsl" />
	
	<xsl:output method="html" omit-xml-declaration="yes" encoding="UTF-8" indent="no" />
	
	<xsl:variable name="constants" select="/view/constants" />
	<xsl:variable name="parameters" select="/view/parameters" />
	<xsl:variable name="settings" select="/view/settings" />
	<xsl:variable name="location" select="/view/actors/location/item" />
	
	<xsl:template match="/view" mode="title">
		<xsl:value-of select="actors/location/item[1]/@name" />
		
		<xsl:if test="actors/location/item[2]">
			<xsl:text> &#x2022; </xsl:text>
			
			<xsl:choose>
				<xsl:when test="normalize-space(actors/location/item[last()]/@name)">
					<xsl:value-of select="normalize-space(actors/location/item[last()]/@name)" />
				</xsl:when>
				<xsl:otherwise>
					<xsl:text>Untitled Document</xsl:text>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>