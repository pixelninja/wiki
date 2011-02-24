<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="../utilities/master.xsl" />
	
	<xsl:template match="/view">
		<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>
			<xsl:apply-templates select="." mode="title" />
		</title>
		
		<link rel="stylesheet" href="{$constants/app-url}/assets/common.css" />
		<script src="{$constants/app-url}/assets/jquery.js"></script>
		<script src="{$constants/app-url}/assets/jquery.scrollto.js"></script>
		<script src="{$constants/app-url}/assets/codemirror/js/codemirror.js"></script>
		<script src="{$constants/app-url}/assets/common.js"></script>
		
		<div
			id="document"
			data-document-url="{$parameters/document-url}"
			data-asset-url="{$constants/app-url}/assets"
			data-base-url="{$constants/base-url}"
		>
			<nav>
				<ul>
					<xsl:if test="$parameters/document-url != 'index'">
						<li class="home"><a href="{$constants/base-url}/">Home</a></li>
					</xsl:if>
					
					<li class="tech"><a href="{$constants/base-url}/technical-documentation">Technical Documentation</a></li>
					<li class="user"><a href="{$constants/base-url}/user-documentation">User Documentation</a></li>
										
					<!--<li class="history"><a href="#history">History</a></li>-->
					<li class="view"><a href="#view">View</a></li>
					
					<xsl:if test="$settings/read-only = 'no'">
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