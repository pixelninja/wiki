# Affliction Wiki

- Version: 0.1 alpha
- Date: Undecided

![Screenshot](https://github.com/rowan-lewis/wiki/raw/master/screenshot.png)


## About the wiki

The Affliction Wiki is a lightweight, easy to use, and most importantly, easy  to read wiki engine. No longer will your wiki documents look like the  designer had no care for typography, instead they will be a thing of  beauty, well **maybe**.

One of the things you'll probably notice, as soon as you edit a document, is that it's written in HTML. This lets you enter **anything** you want into a document without having to struggle with a limited language such as Markdown, or some obscure language only known to your wiki developer.

The one difference you should know about - you don't have to enter your own paragraph elements, instead the wiki takes care of it for you, making the source for your documents much more readable.


## Installation

It's  pretty easy to install the wiki, as there is currently no release,  there is no package to download. Instead we will be fetching the latest  version from source control using git.

<dl>
    <dt>Use git to clone the repository:</dt>
    <dd><code>git clone git://github.com/rowan-lewis/wiki.git</code></dd>
    <dt>Copy the example .htaccess file:</dt>
    <dd><code>cd wiki; cp .htaccess.example .htaccess</code></dd>
    <dt>Copy the example config.php file:</dt>
    <dd><code>cp config.php config.php</code></dd>
    <dt>Configure the wiki to run in a sub directory:</dt>
    <dd>Edit the .htaccess file and change the line <code>RewriteBase /</code> to match your sub directory</dd>
</dl>

*Thats it!* Your  wiki should be up and running. To create a new document, simply go to  the index of your wiki and add the name of your document to the URL. A  blank document will automatically be created with the name you entered -  all you need to do is click edit.
