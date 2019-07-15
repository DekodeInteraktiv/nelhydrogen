<?php
// Company info
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <%
    var companyInfo = manamind[1].companyInfo;
    %>
    <table class="company-info">
        <tbody>
        <tr>
            <td><?php _e( 'ISIN', 'nel' ); ?></td>
            <td><%=companyInfo.isin.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Org. number', 'nel' ); ?></td>
            <td><%=companyInfo.organizationNumber.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Ticker', 'nel' ); ?></td>
            <td><%=companyInfo.ticker.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Exchange', 'nel' ); ?></td>
            <td><%=companyInfo.exchange.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Round lot', 'nel' ); ?></td>
            <td><%=companyInfo.roundlot.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Nominal value', 'nel' ); ?></td>
            <td><%=companyInfo.nominalValue.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Outstanding shares', 'nel' ); ?></td>
            <td data-filter="round,separator"><%=companyInfo.sharesOut.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Market cap', 'nel' ); ?></td>
            <td data-filter="round,separator"><%=companyInfo.marketCap.text%></td>
        </tr>
        </tbody>
    </table>
</script>