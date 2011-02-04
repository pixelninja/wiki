<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="../utilities/output.xsl" />
	<xsl:import href="../utilities/toc.xsl" />
	
	<xsl:output method="html" omit-xml-declaration="yes" encoding="UTF-8" indent="no" />
	
	<xsl:template match="/view">
		<preview>
			<xsl:apply-templates select="actors/preview/*" mode="output" />
		</preview>
	</xsl:template>
</xsl:stylesheet>