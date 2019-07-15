<script type="text/html" id="tmpl_cision_item">
    <tr class="feed-item info-type-<%=information_type%>">
        <td class="col-0 col-first">
            <h4><a class="detail-link" href="<%=url%>"><%=title%></a></h4>
        </td>
        <td class="col-1">
            <span class="meta post-date-label"><%=date%></span>
        </td>
        <td class="col-2">
            <% if (attachments.length > 0) { %>
            <div class="filelist cision-filelist">
                <ul>
                    <% for ( var i = 0; i < attachments.length; i++ ) { %>
                    <li class="file"><a class="icon-file" title="Download: <%=attachments[i].filename%>" target="_blank"
                                        href="<%=attachments[i].url%>"><%=attachments[i].title%></a></li>
                    <% } %>
                </ul>
            </div>
            <% } %>
        </td>
        <td class="col-3 col-last">
            <span><%=information_type_text%></span>
        </td>
    </tr>
</script>