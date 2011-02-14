<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="../utilities/master.xsl" />
	
	<xsl:template match="/view">
		<preview>
			<xsl:attribute name="title">
				<xsl:apply-templates select="." mode="title" />
			</xsl:attribute>
			
			<xsl:apply-templates select="actors/preview/@*" mode="output" />
			<xsl:apply-templates select="actors/preview/*" mode="output" />
		</preview>
	</xsl:template>
</xsl:stylesheet>