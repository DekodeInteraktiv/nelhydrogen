<script type="text/html" id="tmpl_cision_article">
    <div class="mfp-text-wrap mfp-article">
        <article class="inner">
            <div class="row align-center">
                <div class="columns medium-10 large-8">
                    <header class="mfp-article-header">
                        <h2 class="title"><%=title%></h2>
                        <p class="date"><%=date%></p>
                    </header>
                    <p class="lead"><%=header%></p>
                    <p class="lead"><%=intro%></p>
                    <div class="wysiwyg"><%=body%></div>
                    <% if (attachments.length > 0) { %>
                    <div class="filelist cision-filelist">
                        <ul>
                            <li class="filelist-label">Documents</li>
                            <% for ( var i = 0; i < attachments.length; i++ ) { %>
                            <li class="file"><a class="icon-file" title="Download: <%=attachments[i].filename%>"
                                                target="_blank"
                                                href="<%=attachments[i].url%>"><%=attachments[i].title%></a></li>
                            <% } %>
                        </ul>
                    </div>
                    <% } %>
                    <footer class="mfp-article-footer">
                        <p><a href="#" class="modal-close btn btn-d btn-small">Close</a></p>
                    </footer>
                </div>
            </div>
        </article>
    </div>
</script>