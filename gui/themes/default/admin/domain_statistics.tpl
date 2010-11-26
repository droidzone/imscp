<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
        <meta http-equiv="X-UA-Compatible" content="IE=8" />
        <title>{TR_ADMIN_DOMAIN_STATISTICS_PAGE_TITLE}</title>
        <meta name="robots" content="nofollow, noindex" />
        <link href="{THEME_COLOR_PATH}/css/imscp.css" rel="stylesheet" type="text/css" />
        <!--[if IE 6]>
        <script type="text/javascript" src="{THEME_COLOR_PATH}/js/DD_belatedPNG_0.0.8a-min.js"></script>
        <script type="text/javascript">
            DD_belatedPNG.fix('*');
        </script>
        <![endif]-->
    </head>

    <body>
        <div class="header">
            {MAIN_MENU}

            <div class="logo">
                <img src="{THEME_COLOR_PATH}/images/imscp_logo.png" alt="i-MSCP logo" />
            </div>
        </div>

        <div class="location">
            <div class="location-area icons-left">
                <h1 class="general">{TR_DOMAIN_STATISTICS}</h1>
            </div>
            <ul class="location-menu">
                <!-- <li><a class="help" href="#">Help</a></li> -->
                <!-- BDP: logged_from -->
                <!-- EDP: logged_from -->
                <li><a class="logout" href="../index.php?logout">{TR_MENU_LOGOUT}</a></li>
            </ul>
            <ul class="path">
            	<li><a href="server_statistic.php">{TR_MENU_STATISTICS}</a></li>
                <li><a href="reseller_statistic.php">{TR_RESELLER_STATISTICS}</a></li>
                <li><!-- <a href="reseller_user_statistics.php?rid={RID}&amp;name={NAME}&amp;month={MONTH}&amp;year={YEAR}">-->{TR_RESELLER_USER_STATISTICS}<!-- </a> --></li>
                <li>{TR_DOMAIN_STATISTICS}</li>
            </ul>
        </div>

        <div class="left_menu">
            {MENU}
        </div>

        <div class="body">
            <!-- BDP: page_message -->
            <div class="warning">{MESSAGE}</div>
            <!-- EDP: page_message -->

            <h2 class="stats"><span>{TR_DOMAIN_STATISTICS}</span></h2>

            <form name="domain_statistics_frm" method="post" action="domain_statistics.php">
            	{TR_MONTH}
            	<select name="month" id="month">
            		<!-- BDP: month_list -->
            			<option {OPTION_SELECTED}>{MONTH_VALUE}</option>
            		<!-- EDP: month_list -->
            	</select>
            	
            	{TR_YEAR}
            	<select name="year" id="year">
            		<!-- BDP: year_list -->
            			<option {OPTION_SELECTED}>{YEAR_VALUE}</option>
            		<!-- EDP: year_list -->
            	</select>
            	<input name="Submit" type="submit" class="button" value="{TR_SHOW}" />
                <input name="uaction" type="hidden" value="show_traff" />
            </form>

            <table>
                <thead>
                    <tr>
                        <th>{TR_DAY}</th>
                        <th>{TR_WEB_TRAFFIC}</th>
                        <th>{TR_FTP_TRAFFIC}</th>
                        <th>{TR_SMTP_TRAFFIC}</th>
                        <th>{TR_POP3_TRAFFIC}</th>
                        <th>{TR_ALL_TRAFFIC}</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td>{TR_ALL}</td>
                        <td>{ALL_WEB_TRAFFIC}</td>
                        <td>{ALL_FTP_TRAFFIC}</td>
                        <td>{ALL_SMTP_TRAFFIC}</td>
                        <td>{ALL_POP3_TRAFFIC}</td>
                        <td>{ALL_ALL_TRAFFIC}</td>
                    </tr>
                </tfoot>
                <tbody>
                    <!-- BDP: traffic_table_item -->
                    <tr>
                        <td>{DATE}</td>
                        <td>{WEB_TRAFFIC}</td>
                        <td>{FTP_TRAFFIC}</td>
                        <td>{SMTP_TRAFFIC}</td>
                        <td>{POP3_TRAFFIC}</td>
                        <td>{ALL_TRAFFIC}</td>
                    </tr>
                    <!-- EDP: traffic_table_item -->
                </tbody>
            </table>
        </div>

        <div class="footer">
            i-MSCP {VERSION}<br />build: {BUILDDATE}<br />Codename: {CODENAME}
        </div>

    </body>
</html>
