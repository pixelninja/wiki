<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="../utilities/output.xsl" />
	
	<xsl:output method="html" omit-xml-declaration="yes" encoding="UTF-8" indent="no" />
	
	<xsl:template match="/view">
		<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<xsl:if test="actors/format/@file != 'index'">
				<xsl:text>Wiki &#x2022; </xsl:text>
			</xsl:if>
			
			<xsl:choose>
				<xsl:when test="normalize-space(actors/format//h1[1])">
					<xsl:value-of select="normalize-space(actors/format//h1[1])" />
				</xsl:when>
				<xsl:otherwise>
					<xsl:text>Untitled Document</xsl:text>
				</xsl:otherwise>
			</xsl:choose>
		</title>
		
		<base href="{constants/base-url}" />
		<link rel="stylesheet" href="{constants/app-url}/assets/common.css" />
		<script src="{constants/app-url}/assets/jquery.js"></script>
		<script src="{constants/app-url}/assets/common.js"></script>
		
		<div id="document" data-file="{actors/format/@file}">
			<nav>
				<ul>
					<li class="edit">Edit</li>
					<li class="view">View</li>
					<li class="save">Save</li>
				</ul>
			</nav>
            <div id="view">
            	<!--<xsl:copy-of select="actors/format/*" />-->
            	<xsl:apply-templates select="actors/format/*" mode="output" />
            </div>
            <textarea id="edit"></textarea>
        </div>
	</xsl:template>
</xsl:stylesheet>