<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="../utilities/output.xsl" />
	<xsl:import href="../utilities/toc.xsl" />
	
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
		
		<link rel="stylesheet" href="{constants/app-url}/assets/common.css" />
		<script src="{constants/app-url}/assets/jquery.js"></script>
		<script src="{constants/app-url}/assets/jquery.scrollto.js"></script>
		<script src="{constants/app-url}/assets/codemirror/js/codemirror.js"></script>
		<script src="{constants/app-url}/assets/common.js"></script>
		
		<div
			id="document"
			data-file="{actors/format/@file}"
			data-asset-url="{constants/app-url}/assets"
			data-base-url="{constants/base-url}"
		>
			<nav>
				<ul>
					<xsl:if test="actors/format/@file != 'index'">
						<li class="home"><a href="{constants/base-url}/">Home</a></li>
					</xsl:if>
					
					<li class="view"><a href="#view">View</a></li>
					
					<xsl:if test="settings/read-only = 'no'">
						<li class="edit"><a href="#edit">Edit</a></li>
						<li class="save"><a>Save</a></li>
					</xsl:if>
				</ul>
			</nav>
            <div id="view">
            	<xsl:apply-templates select="actors/format/*" mode="output" />
            </div>
        </div>
	</xsl:template>
</xsl:stylesheet>