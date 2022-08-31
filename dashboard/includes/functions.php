<?php
// error_reporting(0);
function query_check($conn,$query)
{
    // echo $query;
    $check = mysqli_query($conn,$query);
    return $check;
}
function add_job($conn)
{
    $title = mysqli_real_escape_string($conn,$_REQUEST['title']);
    $job_desc = mysqli_real_escape_string($conn,$_REQUEST['job_desc']);
    $app_link = mysqli_real_escape_string($conn,$_REQUEST['app_link']);
    $application = mysqli_real_escape_string($conn,$_REQUEST['application']);
    $start = mysqli_real_escape_string($conn,$_REQUEST['start']);
    $contact_person = mysqli_real_escape_string($conn,$_REQUEST['contact_person']);
    $telephone = mysqli_real_escape_string($conn,$_REQUEST['telephone']);
    $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
    $aufgabe = mysqli_real_escape_string($conn,$_REQUEST['aufgabe']);
    $anforderungen = mysqli_real_escape_string($conn,$_REQUEST['anforderungen']);
    $benefits = mysqli_real_escape_string($conn,$_REQUEST['benefits']);
    $date = date('Y-m-d', strtotime($_REQUEST['date']));
    $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));

    if (isset($_REQUEST['c_id'])) {
        $c_id = mysqli_real_escape_string($conn,$_REQUEST['c_id']);
    } else {
        $c_id = '';
    }

    $sql = query_check($conn,"INSERT INTO `jobs` (`title`,`c_id`,`job_desc`,`app_link`,`application`,`date`,
    `end_date`,`status`,`feature`,`start`,`aufgabe`,`anforderungen`,`benefits`,`contact_person`,`telephone`,`email`)
    VALUES ('$title','$c_id','$job_desc','$app_link','$application','$date','$end_date','0','0','$start',
    '$aufgabe','$anforderungen','$benefits','$contact_person','$telephone','$email')");
    if($sql){
        $j_id = mysqli_insert_id($conn);
        if (isset($_REQUEST['cat_id'])) {
            $category = $_REQUEST['cat_id'];
            foreach ($category as $cat_id) {
                $sql2 = query_check($conn,"INSERT INTO `job_cat` (`j_id`,`cat_id`) VALUES ('$j_id','$cat_id')");
            }
        }
        if (isset($_REQUEST['arb_id'])) {

        $arbeitszeit = $_REQUEST['arb_id'];
            foreach ($arbeitszeit as $arb_id) {
                $sql3 = query_check($conn,"INSERT INTO `job_arb` (`j_id`,`arb_id`) VALUES ('$j_id','$arb_id')");
            }
        }
        if (isset($_REQUEST['sort_id'])) {

            $arbeitsort = $_REQUEST['sort_id'];
            foreach ($arbeitsort as $sort_id) {
                $sql3 = query_check($conn,"INSERT INTO `job_sort` (`j_id`,`sort_id`) VALUES ('$j_id','$sort_id')");
            }
        }
        $info = '<div class="notification success closeable">Job Posted Successfully!</div>';
        // header("Refresh:2; url=add_job.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}


function duplicate_job($conn)
{
    $j_id = mysqli_real_escape_string($conn,$_REQUEST['duplicate']);

    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` = '$j_id'");
    $row = mysqli_fetch_assoc($sql);
    if(!empty($row)){
        extract($row);
        $date = date('Y-m-d H:i:s');

        $sql = query_check($conn,"INSERT INTO `jobs` (`title`,`c_id`,`job_desc`,`date`,`end_date`,`status`,`feature`)
        VALUES ('$title','$c_id','$job_desc','$date','$end_date','1','0')");
        $j_id1 = mysqli_insert_id($conn);

        $sql1 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id'");
        $row1 = mysqli_fetch_assoc($sql1);
        if (!empty($row1)) {
            do {
                $arb_id = $row1['arb_id'];
                $sql1_1 = query_check($conn,"INSERT INTO `job_arb` (`j_id`, `arb_id`) Values ('$j_id1','$arb_id')");
            } while ($row1 = mysqli_fetch_assoc($sql1));
        }

        $sql2 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id'");
        $row2 = mysqli_fetch_assoc($sql2);
        if (!empty($row2)) {
            do {
                $sort_id = $row2['sort_id'];
            $sql2_2 = query_check($conn,"INSERT INTO `job_sort` (`j_id`, `sort_id`) Values ('$j_id1','$sort_id')");
        } while ($row2 = mysqli_fetch_assoc($sql2));
        }

        $sql3 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id'");
        $row3 = mysqli_fetch_assoc($sql3);
        if (!empty($row3)) {
            do {
                $cat_id = $row3['cat_id'];
            $sql3_3 = query_check($conn,"INSERT INTO `job_cat` (`j_id`, `cat_id`) Values ('$j_id1','$cat_id')");
        } while ($row3 = mysqli_fetch_assoc($sql3));
    }

        $info = '<div class="notification success closeable">Job Duplicated Successfully!</div>';
        header("Refresh:2; url=index.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}
function duplicate_cat($conn)
{
    $cat_id = mysqli_real_escape_string($conn,$_REQUEST['duplicate']);

    $sql = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
    $row = mysqli_fetch_assoc($sql);
    if(!empty($row)){
        $category = $row['category'];
        $desc = $row['desc'];
        $date = date('Y-m-d H:i:s');

        $sql = query_check($conn,"INSERT INTO `category` (`category`,`desc`,`date`)
        VALUES ('$category','$desc','$date')");
        $info = '<div class="notification success closeable">Category Duplicated Successfully!</div>';
        header("Refresh:2; url=category.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}


function duplicate_company($conn)
{
    $c_id = mysqli_real_escape_string($conn,$_REQUEST['duplicate']);

    $sql = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
    $row = mysqli_fetch_assoc($sql);
    if(!empty($row)){

        $company = $row['company'];
        $desc = $row['desc'];
        $place = $row['place'];
        $name = $row['name'];
        $apply = $row['apply'];
        $phone = $row['phone'];
        $email = $row['email'];
        $website = $row['website'];
        $date = date('Y-m-d H:i:s');

        $sql = query_check($conn,"INSERT INTO `company` (`company`,`desc`,`place`,`name`,
        `apply`,`phone`,`email`,`website`,`date`) VALUES ('$company','$desc','$place',
        '$name','$apply','$phone','$email','$website','$date')");
        $info = '<div class="notification success closeable">Company Duplicated Successfully!</div>';
        header("Refresh:2; url=company.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}

function add_company($conn)
{
    $company = mysqli_real_escape_string($conn,$_REQUEST['company']);
    $desc = mysqli_real_escape_string($conn,$_REQUEST['desc']);
    $place = mysqli_real_escape_string($conn,$_REQUEST['place']);
    $name = mysqli_real_escape_string($conn,$_REQUEST['name']);
    $apply = mysqli_real_escape_string($conn,$_REQUEST['apply']);
    $phone = mysqli_real_escape_string($conn,$_REQUEST['phone']);
    $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
    $website = mysqli_real_escape_string($conn,$_REQUEST['website']);
    $instagram = mysqli_real_escape_string($conn,$_REQUEST['instagram']);
    $facebook = mysqli_real_escape_string($conn,$_REQUEST['facebook']);
    $youtube = mysqli_real_escape_string($conn,$_REQUEST['youtube']);
    $date = date('Y-m-d H:i:s');
    if(!empty($_FILES['c_logo']['name'])){

        $target_dir = 'logos/';
        $temp = $_FILES['c_logo']['tmp_name'];
        $uniq = time().rand(1000,9999);
        $info = pathinfo($_FILES['c_logo']['name']);

        $target_file = $target_dir . basename($_FILES["c_logo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        //    Allow certain files formats
        if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png" ) {
            $info = '<div class="notification error closeable"  role="alert">Sorry only JPF,JPEG and PNG formats are allowed!</div>';
            return $info;
            die();
        }

        //  Check image size
        $size = $_FILES["c_logo"]["size"];
        if ($size > 5000000) {
        $info ='<div class="notification error closeable" role="alert">Sorry! logo cannot be larger than 5MB</div>';
        return $info;
            die();
        }
        $image_name = "c_logo_".$uniq.".".$info['extension']; //with your created name
        if(file_exists($target_dir.$image_name)){

            while(file_exists($target_dir)) {
        $temp = $_FILES['c_logo']['tmp_name'];
        $uniq = time().rand(1000,9999);
        $info = pathinfo($_FILES['c_logo']['name']);
        $image_name = "c_logo_".$uniq.".".$info['extension']; //with your created name
            }

        move_uploaded_file($temp, $target_dir.$image_name);
        }

        move_uploaded_file($temp, $target_dir.$image_name);
        $attach = "`c_logo` ,";
        $value = "'{$image_name}' ,";
    }else{
        $attach = "`c_logo` ,";
        $value = "'' ,";
    }

    $sql = query_check($conn,"INSERT INTO `company` (`company`,`desc`,`place`,`name`,
    `apply`,`phone`,`email`,`website`,`instagram`,`facebook`,`youtube`,`c_logo`,`date`,`status`,`feature`) VALUES ('$company','$desc','$place',
    '$name','$apply','$phone','$email','$website','$instagram','$facebook','$youtube',".$value."'$date','0','0')");
    if($sql){
        $info = '<div class="notification success closeable">Company Added Successfully!</div>';
        header("Refresh:2; url=add_company.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}
function ad_show_jobs($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $j_id = $row['j_id'];
            $featured = '';
            $featured_option = '';
            if ($row['feature'] == 1) {
                $featured = '<b class="text-success">Featured</b>';
                $featured_option = '
                <td><a href="index.php?feature=0&j_id='.$row['j_id'].'" class="btn btn-success btn-sm w-100">Premium</a></td>';
              }else {
                $featured = '<b class="text-warning">Normal</b>';
                $featured_option = '
                <td><a href="index.php?feature=1&j_id='.$row['j_id'].'" class="btn btn-danger btn-sm w-100">Normal</a></td>';
              }
              $status_option = '';
              $status = '';
              if ($row['status'] == 1) {
                  $status = '<b class="text-success">Aktiv</b>';
                  $status_option = '
                  <td><a href="index.php?status=0&j_id='.$row['j_id'].'" class="btn btn-success btn-sm w-100">Aktiv</a></td>';
                }else {
                    $status = '<b class="text-danger">Inactive</b>';
                  $status_option = '
                  <td><a href="index.php?status=1&j_id='.$row['j_id'].'" class="btn btn-danger btn-sm w-100">Deaktiviert</a></td>';
                }
            $category = '';
            $sql1 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row1 = mysqli_fetch_assoc($sql1);
            if (!empty($row1)) {
                do {
                    $cat_id = $row1['cat_id'];
                    $sql2 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row2 = mysqli_fetch_assoc($sql2);
                    if (!empty($row2)) {
                        $category .= $row2['category'] . ", ";
                    }
                } while ($row1 = mysqli_fetch_assoc($sql1));
            }


            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row1 = mysqli_fetch_assoc($sql1);
            $show .= '<tr>
            <td>'.$row['j_id'].'</td>
            <td><a href="edit_company.php?c_id='.$row1['c_id'].'">'.$row1['company'].'</a></td>
            <td><a href="edit_job.php?j_id='.$row['j_id'].'">'.$row['title'].'</a></td>
            '.$status_option.'
            '.$featured_option.'
            <td><a href="index.php?duplicate='.$row['j_id'].'" class="btn btn-primary btn-sm w-100">Duplizieren</a></td>
            <td><button class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="delete_job('.$row['j_id'].')">Löschen</button></td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
    }
    return $show;
}
function ad_show_company($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `company` WHERE `c_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {$featured = '';
            $featured_option = '';
            if ($row['feature'] == 1) {
                $featured = '<b class="text-success">Featured</b>';
                $featured_option = '
                <option value="company.php?feature=0&c_id='.$row['c_id'].'">Unfeature</option>';
              }else {
                $featured = '<b class="text-warning">Normal</b>';
                $featured_option = '
                <option value="company.php?feature=1&c_id='.$row['c_id'].'" >Feature</option>';
              }
            $status = '';
            if ($row['status'] == 1) {
                $status = '<b class="text-success">Active</b>';
                $status_option = '
                <option value="company.php?status=0&c_id='.$row['c_id'].'">Inactive</option>';
              }else {
                  $status = '<b class="text-danger">Inactive</b>';
                $status_option = '
                <option value="company.php?status=1&c_id='.$row['c_id'].'" >Active</option>';
              }
            $show .= '<tr>
            <td>'.$row['c_id'].'</td>
            <td><a href="edit_company.php?c_id='.$row['c_id'].'">'.$row['company'].'</a></td>
            <td>'.$row['phone'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$status.'</td>
            <td>'.$featured.'</td>
            <td class="text-center">
                <select class="form-control" onchange="location = this.value;">
                    <option selected disabled>Select an action</option>
                    '.$status_option.'
                    '.$featured_option.'
                    <option value="company.php?duplicate='.$row['c_id'].'" >Duplicate</option>
                </select>
            </td>
            <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="delete_company('.$row['c_id'].')">Delete</button></td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No companies present!</div></td></tr>';
    }
    return $show;
}
function job_details($conn)
{
    $show = '';
    $j_id = mysqli_real_escape_string($conn,$_REQUEST['j_id']);
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` = '$j_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $c_id = $row['c_id'];

            $sql3 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row3 = mysqli_fetch_assoc($sql3);
            $logo = '';
            if (!empty($row3['c_logo'])) {
                $logo = '<img src="dashboard/logos/'.$row3['c_logo'].'" alt="">';
            }else{
                $logo = '<img src="dashboard/logos/placeholder.jpg" alt="">';
            }


            $j_id = $row['j_id'];
            $category = '';
            $sql1 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row1 = mysqli_fetch_assoc($sql1);
            $j = 1;
            if (!empty($row1)) {
                do {
                    $cat_id = $row1['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql1_1 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row1_1 = mysqli_fetch_assoc($sql1_1);
                    if (!empty($row1_1)) {
                        $category .= $comma.$row1_1['category'];
                        $j++;
                    }
                } while ($row1 = mysqli_fetch_assoc($sql1));
            }
            $arbeitszeit = '';
            $sql2 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row2 = mysqli_fetch_assoc($sql2);
            $k = 1;
            if (!empty($row2)) {
                do {
                    $arb_id = $row2['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql2_1 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row2_1 = mysqli_fetch_assoc($sql2_1);
                    if (!empty($row2_1)) {
                        $arbeitszeit .= $comma.$row2_1['arbeitszeit'];
                        $k++;
                    }
                } while ($row2 = mysqli_fetch_assoc($sql2));
            }

            $arbeitsort = '';
            $sql5 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row5 = mysqli_fetch_assoc($sql5);
            $j = 1;
            if (!empty($row5)) {
                do {
                    $sort_id = $row5['sort_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql5_1 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row5_1 = mysqli_fetch_assoc($sql5_1);
                    if (!empty($row5_1)) {
                        $arbeitsort .= $comma.$row5_1['arbeitsort'];
                        $j++;
                    }
                } while ($row5 = mysqli_fetch_assoc($sql5));
            }
            $aufgabe = '';
            if (!empty($row['aufgabe'])) {
                $aufgabe = '<div class="single-page-section">
                <h3 class="margin-bottom-25">Aufgabe</h3>
                '.nl2br($row['aufgabe']).'
            </div>';
            }
            
            $anforderungen = '';
            if (!empty($row['anforderungen'])) {
                $anforderungen = '<div class="single-page-section">
                <h3 class="margin-bottom-25">Anforderungen</h3>
                '.nl2br($row['anforderungen']).'
            </div>';
            }
            
            $benefits = '';
            if (!empty($row['benefits'])) {
                $benefits = '<div class="single-page-section">
                <h3 class="margin-bottom-25">Benefits</h3>
                '.nl2br($row['benefits']).'
            </div>';
            }
            $application = '';
            if (!empty($row['application'])) {
                $application = '<div class="single-page-section">
                <h3 class="margin-bottom-25">Jetzt für diesen Job bewerben!</h3>
				'.nl2br($row['application']).'
            </div>';
            }
            
            $start = '';
            if (!empty($row['start'])) {
                $start = '<h4 class="margin-bottom-25">Job Start: '.$row['start'].'</h4>';
            }
            $contact_person = '';
            if (!empty($row['contact_person'])) {
                $contact_person = '<h4 class="margin-bottom-25">Job Ansprechpartner: '.$row['contact_person'].'</h4>';
            }
            $telephone = '';
            if (!empty($row['telephone'])) {
                $telephone = '<h4 class="margin-bottom-25">Job Telefon: 
				<a href="tel:'.$row['telephone'].'">'.$row['telephone'].'</a>
                </h4>';
            }
            $email = '';
            if (!empty($row['email'])) {
                $email = '<h4 class="margin-bottom-25">Job E-Mail: 
				<a href="mailto:'.$row['email'].'">'.$row['email'].'</a>
                </h4>';
            }
            $app_link = '';
            if (!empty($row['app_link'])) {
                $app_link = '<div class="single-page-section">
                <h3 class="margin-bottom-25">Jetzt für diesen Job bewerben!</h3>
                <a href="'.$row['app_link'].'" target="_blank" rel="noopener noreferrer">'.$row['app_link'].'</a>
            </div>';
            }
            $show .= '<!-- Titlebar
================================================== -->
<div class="single-page-header" data-background-image="images/single-job.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image"><a href="arbeitgeber.php?c_id='.$row['c_id'].'">'.$logo.'</a></div>
						<div class="header-details">
							<h3>'.$row['title'].'</h3>
							<h5><a href="arbeitgeber.php?c_id='.$row['c_id'].'"><i class="icon-material-outline-business"></i> '.$row3['company'].'</a></h5>

						</div>
					</div>
          <!--
					<div class="right-side">
						<div class="salary-box">
							<div class="salary-type">Annual Salary</div>
							<div class="salary-amount">$35k - $38k</div>
						</div>
					</div>
          -->
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">

		<!-- Content -->
		<div class="col-xl-8 col-lg-8 content-right-offset">

        <div class="single-page-section">
            <h3 class="margin-bottom-25">Job Beschreibung</h3>
            '.nl2br($row['job_desc']).'
        </div>

        '.$aufgabe.$anforderungen.$benefits.'

      <div class="single-page-section">
				'.$application.'
                
        '.$start.$contact_person.$telephone.$email.'
<br>
        '.$app_link.'
			</div>

		</div>


		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">

				<!-- <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim">Apply Now <i class="icon-material-outline-arrow-right-alt"></i></a> -->

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<div class="job-overview">
						<div class="job-overview-headline">Job Details</div>
						<div class="job-overview-inner">
							<ul>
                                <li>
                                    <i class="icon-material-outline-assignment"></i>
                                    <span>Job Kategorie</span>
                                    <h5>'.$category.'</h5>
                                </li>
								<li>
									<i class="icon-material-outline-location-on"></i>
									<span>Job Arbeitsort</span>
									<h5>'.$arbeitsort.'</h5>
								</li>
								<li>
									<i class="icon-material-outline-business-center"></i>
									<span>Anstellung / Arbeitszeit</span>
									<h5>'.$arbeitszeit.'</h5>
								</li>

								<li>
									<i class="icon-material-outline-access-time"></i>
									<span>Job Veröffentlicht</span>
									<h5>'.date('d.m.Y',strtotime($row['date'])).'</h5>
								</li>

                                <li>
									<i class="icon-material-outline-https"></i>
									<span>Job Bewerbungsfrist</span>
									<h5>'.date('d.m.Y',strtotime($row['end_date'])).'</h5>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="sidebar-widget">
					<div class="job-overview">
						<div class="job-overview-headline">Arbeitgeber Details</div>
						<div class="job-overview-inner">
							<ul>
                                <li>
                                    <i class="icon-material-outline-assignment"></i>
                                    <span>Arbeitgeber</span>
                                                                      <a href="arbeitgeber.php?c_id='.$row['c_id'].'">'.$row3['company'].'</a>

                                </li>


								<li>
									<i class="icon-material-outline-location-on"></i>
									<span>Firmensitz</span>
									<h5>'.$row3['place'].'</h5>
								</li>
								<li>
									<i class="icon-material-outline-account-circle"></i>
									<span>Ansprechpartner:in</span>
									<h5>'.$row3['name'].'</h5>
								</li>

								<li>
									<i class="icon-line-awesome-phone"></i>
									<span>Telefon</span>
									<h5><a href="tel:'.$row3['phone'].'">'.$row3['phone'].'</a></h5>
								</li>

                                <li>
									<i class="icon-material-baseline-mail-outline"></i>
									<span>E-Mail</span>
									<h5><a href="mailto:'.$row3['email'].'">'.$row3['email'].'</a></h5>
								</li>

                <li>
									<i class="icon-material-outline-language"></i>
									<span>Webseite</span>
									<h5 style="word-break: break-all;"><a href="'.$row3['website'].'" target="_blank">'.$row3['website'].'</a></h5>
								</li>
							</ul>
						</div>
					</div>
				</div>




				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<!--<h3>Bookmark or Share</h3>


					<button class="bookmark-button margin-bottom-25">
						<span class="bookmark-icon"></span>
						<span class="bookmark-text">Bookmark</span>
						<span class="bookmarked-text">Bookmarked</span>
					</button>
          Bookmark Button -->

					<!-- Copy URL
					<div class="copy-url">
						<input id="copy-url" type="text" value="" class="with-border">
						<button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Link kopieren!" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
					</div>-->

					<!-- Share Buttons
					<div class="share-buttons margin-top-25">
						<div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
						<div class="share-buttons-content">
							<span>Interesting? <strong>Share It!</strong></span>
							<ul class="share-buttons-icons">
								<li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
								<li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
								<li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
								<li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
							</ul>
						</div>
            </div>-->

				</div>

			</div>
		</div>

	</div>
</div>'
        ;
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No job present!</div></td></tr>';
    }
    return $show;
}


function company_details($conn)
{
    $show = '';
    $c_id = mysqli_real_escape_string($conn,$_REQUEST['c_id']);
    $sql = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {

        do {

            $show1 = show_company_jobs($row['c_id'],$conn);
            $logo = '';
            if (!empty($row['c_logo'])) {
                $logo = '<img src="dashboard/logos/'.$row['c_logo'].'" alt="Firmen Logo">';
            }else{
                $logo = '<img src="dashboard/logos/placeholder.jpg" alt="Firmen Logo">';
            }
            $show .= '
<!-- Titlebar
================================================== -->
<div class="single-page-header" data-background-image="images/single-company.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image">'.$logo.'</div>
						<div class="header-details">
							<h3>'.$row['company'].'</h3>
							<ul>
								<li><div>Firmensitz: '.$row['place'].'</div></li>
							</ul>
						</div>
					</div>
					<div class="right-side">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">

		<!-- Content -->
		<div class="col-xl-8 col-lg-8 content-right-offset">

			<div class="single-page-section">
				<h3 class="margin-bottom-25">'.$row['company'].' Beschreibung:</h3>
				'.nl2br($row['desc']).'
			</div>

			<!-- Boxed List -->
			<div class="boxed-list margin-bottom-60">
				<div class="boxed-list-headline">
					<h3><i class="icon-material-outline-business-center"></i> Jobs bei '.$row['company'].' </h3>
				</div>

				<div class="listings-container compact-list-layout">

					<!-- Job Listing -->
					'.$show1[1].'

					<!-- Job Listing -->
					'.$show1[0].'
				</div>

			</div>
			<!-- Boxed List / End -->

			<!-- Boxed List  reviews End -->

		</div>


		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">

				<!-- Location -->
				<div class="sidebar-widget">
					<h3>Infos:</h3>
					<p>

          <b>Ansprechpartner:</b>
          <br>
          '.$row['name'].'
          <br><br>


          <b>Telefon</b>
          <br>
          <a href="tel:'.$row['phone'].'">'.$row['phone'].'</a>
          <br><br>

          <b>E-Mail</b>
          <br>
          <a href="mailto:'.$row['email'].'">'.$row['email'].'</a>
          <br><br>

          <b>Webseite</b>
          <br>
          <a href="'.$row['website'].'" target="_blank">'.$row['website'].'</a>
<br><br>

          <b>Karriereseite</b>
          <br>
          <a href="'.$row['apply'].'" target="_blank">'.$row['apply'].'</a>




          </p>

          <br>
				</div>

				<!-- soziale profile -->


			</div>
		</div>

	</div>
</div>


<!-- Spacer -->
<div class="margin-top-15"></div>
<!-- Spacer / End-->
';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No job present!</div></td></tr>';
    }
    return $show;
}

function category_details($conn)
{
    $show = '';
    $cat_id = mysqli_real_escape_string($conn,$_REQUEST['cat_id1']);
    $sql = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<tr>
            <th colspan="2" class="text-center"><h2>'.$row['category'].'</h2></th>
        </tr>
        <tr>
            <th>Beschreibung </th>
            <td>'.nl2br($row['desc']).'</td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No category present!</div></td></tr>';
    }
    return $show;
}

function arbeitsort_details($conn)
{
    $show = '';
    $sort_id = mysqli_real_escape_string($conn,$_REQUEST['sort_id1']);
    $sql = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<tr>
            <th colspan="2" class="text-center"><h2>'.$row['arbeitsort'].'</h2></th>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No arbeitsort present!</div></td></tr>';
    }
    return $show;
}

function place_details($conn)
{
    $show = '';
    $place = mysqli_real_escape_string($conn,$_REQUEST['place']);
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `arbeitsort` = '$place'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<tr>
            <th colspan="2" class="text-center"><h2>'.$row['arbeitsort'].'</h2></th>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No place present!</div></td></tr>';
    }
    return $show;
}


function arbeitszeit_details($conn)
{
    $show = '';
    $arb_id = mysqli_real_escape_string($conn,$_REQUEST['arb_id1']);
    $sql = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<tr>
            <th colspan="2" class="text-center"><h2>'.$row['arbeitszeit'].'</h2></th>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No arbeitzeit present!</div></td></tr>';
    }
    return $show;
}


function ad_job_details($conn)
{
    $show = '';
    $j_id = mysqli_real_escape_string($conn,$_REQUEST['j_id']);
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` = '$j_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $c_id = $row['c_id'];

            $sql3 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row3 = mysqli_fetch_assoc($sql3);
            $logo = '';
            if (!empty($row3['c_logo'])) {
                $logo = '<img src="dashboard/logos/'.$row3['c_logo'].'" height="50">';
            }


            $j_id = $row['j_id'];
            $category = '';
            $sql1 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row1 = mysqli_fetch_assoc($sql1);
            $j = 1;
            if (!empty($row1)) {
                do {
                    $cat_id = $row1['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql1_1 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row1_1 = mysqli_fetch_assoc($sql1_1);
                    if (!empty($row1_1)) {
                        $category .= $comma.$row1_1['category'];
                        $j++;
                    }
                } while ($row1 = mysqli_fetch_assoc($sql1));
            }
            $arbeitszeit = '';
            $sql2 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row2 = mysqli_fetch_assoc($sql2);
            $k = 1;
            if (!empty($row2)) {
                do {
                    $arb_id = $row2['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql2_1 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row2_1 = mysqli_fetch_assoc($sql2_1);
                    if (!empty($row2_1)) {
                        $arbeitszeit .= $comma.$row2_1['arbeitszeit'];
                        $k++;
                    }
                } while ($row2 = mysqli_fetch_assoc($sql2));
            }

            $arbeitsort = '';
            $sql5 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row5 = mysqli_fetch_assoc($sql5);
            $j = 1;
            if (!empty($row5)) {
                do {
                    $sort_id = $row5['sort_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql5_1 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row5_1 = mysqli_fetch_assoc($sql5_1);
                    if (!empty($row5_1)) {
                        $arbeitsort .= $comma.$row5_1['arbeitsort'];
                        $j++;
                    }
                } while ($row5 = mysqli_fetch_assoc($sql5));
            }
            $show .= '<tr>
            <th colspan="2" class="text-center"><h2>'.$row['title'].'</h2></th>
        </tr>
        <tr>
            <th>Job Kategorie</th>
            <td>'.$category.'</td>
        </tr>
        <tr>
            <th>Veröffentlicht am</th>
            <td>'.date('d-M-Y',strtotime($row['date'])).'</td>
        </tr>
        <tr>
            <th>ValidThru</th>
            <td>'.date('d-M-Y',strtotime($row['end_date'])).'</td>
        </tr>
        <tr>
            <th>Arbeitszeit </th>
            <td>'.$arbeitszeit.'</td>
        </tr>
        <tr>
            <th>Job Beschreibung </th>
            <td>'.nl2br($row['job_desc']).'</td>
        </tr>
        <tr>
            <th>Arbeitsort</th>
            <td>'.$arbeitsort.'</td>
        </tr>
        <tr>
            <th> Bewerbungsformular </th>
            <td><a href="'.$row['app_link'].'" target="_blank" rel="noopener noreferrer">'.$row['app_link'].'</a></td>
        </tr>
        <tr>
            <th>Bewerbung </th>
            <td>'.nl2br($row['application']).'</td>
        </tr>
        <tr>
            <th>Firma </th>
            <td>'.$logo.' <a href="company_details.php?c_id='.$row3['c_id'].'">'.$row3['company'].'</a></td>
        </tr>
        <tr>
            <th>Beschreibung </th>
            <td>'.nl2br($row3['desc']).'</td>
        </tr>
        <tr>
            <th>Firmensitz </th>
            <td>'.$row3['place'].'</td>
        </tr>
        <tr>
            <th>Ansprechpartner </th>
            <td>'.$row3['name'].'</td>
        </tr>
        <tr>
            <th>Karriereseite </th>
            <td><a href="'.$row3['apply'].'" target="_blank" rel="noopener noreferrer">'.$row3['apply'].'</a></td>
        </tr>
        <tr>
            <th>Telefon </th>
            <td><a href="tel:'.$row3['phone'].'">'.$row3['phone'].'</a></td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td><a href="mailto:'.$row3['email'].'">'.$row3['email'].'</a></td>
        </tr>
        <tr>
            <th>Webseite </th>
            <td><a href="'.$row3['website'].'" target="_blank" rel="noopener noreferrer">'.$row3['website'].'</a></td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No job present!</div></td></tr>';
    }
    return $show;
}



function ad_company_details($conn)
{
    $show = '';
    $c_id = mysqli_real_escape_string($conn,$_REQUEST['c_id']);
    $sql = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $logo = '<b class="text-danger">No Logo Present</b>';
            if (!empty($row['c_logo'])) {
                $logo = '<img src="logos/'.$row['c_logo'].'" height="80">';
            }
            $show .= '<tr>
            <th colspan="2"><h2>'.$row['company'].'</h2></th>
        </tr>
        <tr>
            <th>Logo </th>
            <td>'.$logo.'</td>
        </tr>
        <tr>
            <th>Beschreibung </th>
            <td>'.nl2br($row['desc']).'</td>
        </tr>
        <tr>
            <th>Firmensitz </th>
            <td>'.$row['place'].'</td>
        </tr>
        <tr>
            <th>Ansprechpartner </th>
            <td>'.$row['name'].'</td>
        </tr>
        <tr>
            <th>Karriereseite </th>
            <td><a href="'.$row['apply'].'" target="_blank" rel="noopener noreferrer">'.$row['apply'].'</a></td>
        </tr>
        <tr>
            <th>Telefon </th>
            <td><a href="tel:'.$row['phone'].'">'.$row['phone'].'</a></td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></td>
        </tr>
        <tr>
            <th>Webseite </th>
            <td><a href="'.$row['website'].'" target="_blank" rel="noopener noreferrer">'.$row['website'].'</a></td>
        </tr>
        <tr>
            <th>Instagram </th>
            <td><a href="'.$row['instagram'].'" target="_blank" rel="noopener noreferrer">'.$row['instagram'].'</a></td>
        </tr>
        <tr>
            <th>Facebook </th>
            <td><a href="'.$row['facebook'].'" target="_blank" rel="noopener noreferrer">'.$row['facebook'].'</a></td>
        </tr>
        <tr>
            <th>Youtube </th>
            <td><a href="'.$row['youtube'].'" target="_blank" rel="noopener noreferrer">'.$row['youtube'].'</a></td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="2"><div class="notification error closeable">No company present!</div></td></tr>';
    }
    return $show;
}



function show_jobs($conn)
{
    $show = $show1 = '';
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 ORDER BY `feature` DESC,`j_id` DESC");
    $row = mysqli_fetch_assoc($sql);

    $f = $n = 0;
    if (!empty($row)) {
        do {
            $c_id = $row['c_id'];
            $sql9 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id' AND `status` = 1 ");
            $row9 = mysqli_fetch_assoc($sql9);


            $j_id = $row['j_id'];
            $category = '';
            $sql11 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row11 = mysqli_fetch_assoc($sql11);
            $j = 1;
            if (!empty($row11)) {
                do {
                    $cat_id = $row11['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql12 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row12 = mysqli_fetch_assoc($sql12);
                    if (!empty($row12)) {
                        $category .= $comma.$row12['category'];
                        $j++;
                    }
                } while ($row11 = mysqli_fetch_assoc($sql11));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }
            $arbeitsort = '';
            $sql3_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row3_1 = mysqli_fetch_assoc($sql3_1);
            $k = 1;
            if (!empty($row3_1)) {
                do {
                    $sort_id = $row3_1['sort_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql3_2 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row3_2 = mysqli_fetch_assoc($sql3_2);
                    if (!empty($row3_2)) {
                        $arbeitsort .= $comma.$row3_2['arbeitsort'];
                        $k++;
                    }
                } while ($row3_1 = mysqli_fetch_assoc($sql3_1));
            }


            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row1 = mysqli_fetch_assoc($sql1);
            if (!empty($row1['c_logo'])) {
                $img = '<img src="dashboard/logos/'.$row1['c_logo'].'"  alt="Firma Logo">';
            }else{
                $img = '';
            }
            $arb_atch = $sort_atch = $cat_atch = '';
            if ($row9['status'] == 1) {
                if (!empty($arbeitszeit)) {
                    $arb_atch = '<li><i class="icon-material-outline-business-center"></i> '.$arbeitszeit.'</li>';
                }
                if (!empty($category)) {
                    $cat_atch = '<li><i class="icon-material-outline-bookmarks"></i> '.$category.'</li>';
                }
                if (!empty($arbeitsort)) {
                    $sort_atch = '<li><i class="icon-material-outline-location-on"></i> '.$arbeitsort.'</li>';
                }
                $featured = '';
            if ($row['feature'] == 1) {
                if ($f < 6) {
                    $show1 .= '
                        <a href="job.php?j_id='.$row['j_id'].'" class="job-listing with-apply-button">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">

                                        <!-- Logo -->
                                        <div class="job-listing-company-logo">
                                            '.$img.'
                                        </div>

                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">'.$row['title'].'</h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li><i class="icon-material-outline-business"></i> '.$row1['company'].'
                                                        <div class="verified-badge" title="Premium Arbeitgeber" data-tippy-placement="top"></div>
                                                    </li>
                                                    '.$arb_atch.$cat_atch.$sort_atch.'
                                                    <li><i class="icon-material-outline-access-time"></i> '.date('j.n.Y',strtotime($row['date'])).'</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Apply Button -->
                                        <span class="list-apply-button ripple-effect">Job Details</span>
                                    </div>
                                </a>
                        ';
                        $f = $f + 1;
                }
            }else{
                if ($n < 10) {
                    $show .= '
                    <a href="job.php?j_id='.$row['j_id'].'" class="job-listing with-apply-button">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Logo -->
                                    <div class="job-listing-company-logo">
                                        '.$img.'
                                    </div>

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">'.$row['title'].'</h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-business"></i> '.$row1['company'].'
                                                    <div class="verified-badge" title="Premium Arbeitgeber" data-tippy-placement="top"></div>
                                                </li>
                                                '.$arb_atch.$cat_atch.$sort_atch.'
                                                <li><i class="icon-material-outline-access-time"></i> '.date('j.n.Y',strtotime($row['date'])).'</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Apply Button -->
                                    <span class="list-apply-button ripple-effect">Job Details</span>
                                </div>
                            </a>
                    ';
                    $n = $n + 1;
                }
                }
            }

        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
        $show1 = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
    }
    return array($show,$show1);
}


function search_jobs($conn)
{
    $show = $show1 = $highlight = $page_links = '';
    if (!isset ($_REQUEST['page']) ) {
        $page = 1;
    } else {
        $page = $_REQUEST['page'];
    }
    if (isset($_REQUEST['q'])) {
        $q = $_REQUEST['q'];

        $results_per_page = 10;
        $page_first_result = ($page-1) * $results_per_page;
        $sql1 = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND (`title` LIKE '%".$q."%' OR `job_desc` LIKE '%".$q."%')");
        $number_of_result = mysqli_num_rows($sql1);
        $number_of_page = ceil ($number_of_result / $results_per_page);

        $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND (`title` LIKE '%".$q."%' OR `job_desc` LIKE '%".$q."%') ORDER BY `feature` DESC,`j_id` DESC LIMIT " . $page_first_result . ',' . $results_per_page." ");
        $highlight .= '
        <script>window.onload = function() {
            highlight("'.$q.'");
          };</script>';
    }else{

        $results_per_page = 10;
        $page_first_result = ($page-1) * $results_per_page;
        $sql1 = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 ");
        $number_of_result = mysqli_num_rows($sql1);
        $number_of_page = ceil ($number_of_result / $results_per_page);

        $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 ORDER BY `feature` DESC,`j_id` DESC LIMIT " . $page_first_result . ',' . $results_per_page." ");
    }

    $row = mysqli_fetch_assoc($sql);

    $page_links = '';
    for($i = 1; $i<= $number_of_page; $i++) {
        $active = '';
        if ($i == $page) {
            $active = 'class="current-page"';
        }
        $page_links .= '<li><a href="suche.php?'.$new_query_string = http_build_query(array_merge($_GET,array('page' => $i))).'" '.$active.'>'.$i.'</a></li>';
    }
    if (!empty($row)) {
        do {

            $c_id = $row['c_id'];
            $sql9 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id' AND `status` = 1 ");
            $row9 = mysqli_fetch_assoc($sql9);
            if ($row9['status'] == 1) {


            $j_id = $row['j_id'];
            $category = '';
            $sql11 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row11 = mysqli_fetch_assoc($sql11);
            $j = 1;
            if (!empty($row11)) {
                do {
                    $cat_id = $row11['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql12 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row12 = mysqli_fetch_assoc($sql12);
                    if (!empty($row12)) {
                        $category .= $comma.$row12['category'];
                        $j++;
                    }
                } while ($row11 = mysqli_fetch_assoc($sql11));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }


            $arbeitsort = '';
            $sql3_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row3_1 = mysqli_fetch_assoc($sql3_1);
            $k = 1;
            if (!empty($row3_1)) {
                do {
                    $sort_id = $row3_1['sort_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql3_2 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row3_2 = mysqli_fetch_assoc($sql3_2);
                    if (!empty($row3_2)) {
                        $arbeitsort .= $comma.$row3_2['arbeitsort'];
                        $k++;
                    }
                } while ($row3_1 = mysqli_fetch_assoc($sql3_1));
            }

            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row1 = mysqli_fetch_assoc($sql1);

            $logo = '';
            if (!empty($row1['c_logo'])) {
                $logo = '<img src="dashboard/logos/'.$row1['c_logo'].'" alt="Firmen Logo">';
            }else{
                $logo = '<img src="dashboard/logos/placeholder.jpg" alt="Firmen Logo">';
            }
            $arb_atch = $sort_atch = $cat_atch = '';
                if (!empty($arbeitszeit)) {
                    $arb_atch = '<li><i class="icon-material-outline-business-center"></i> '.$arbeitszeit.'</li>';
                }
                if (!empty($category)) {
                    $cat_atch = '<li><i class="icon-material-outline-bookmarks"></i> '.$category.'</li>';
                }
                if (!empty($arbeitsort)) {
                    $sort_atch = '<li><i class="icon-material-outline-location-on"></i> '.$arbeitsort.'</li>';
                }
            $featured = '';
            if ($row['feature'] == 1) {
                $featured = ' bookmarked';
            }
                $show .= '<a href="job.php?j_id='.$row['j_id'].'" class="job-listing">

                <!-- Job Listing Details -->
                <div class="job-listing-details">

                    <!-- Logo -->
                    <div class="job-listing-company-logo">
                    '.$logo.'
                    </div>

                    <!-- Details -->
                    <div class="job-listing-description">
                        <h3 class="job-listing-title">'.$row['title'].'</h3>

                        <!-- Job Listing Footer -->
                        <div class="job-listing-footer">
                            <ul>
                            <li><i class="icon-material-outline-business"></i> '.$row1['company'].'
                                <div class="verified-badge" title="Premium Arbeitgeber" data-tippy-placement="top"></div>
                            </li>
                            '.$arb_atch.$cat_atch.$sort_atch.'
                            <li><i class="icon-material-outline-access-time"></i> '.date('j.n.Y',strtotime($row['date'])).'</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bookmark -->
                    <span class="bookmark-icon'.$featured.'" title="Premium Job"></span>
                </div>
            </a>';
            }
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="notification error closeable">No job found!!</div>';
        $show1 = '';
    }
    return array($show,$show1,$page_links);
}


function filter_search($conn)
{
    $show = $show1 = $page_links = '';
    $c_jobs = array();
    $a_jobs = array();
    $s_jobs = array();
    $jobs = array();
    $z = 1;

    if (isset($_REQUEST['cat_id'])) {
        $cat_ids =$_REQUEST['cat_id'];
        foreach ($cat_ids as $cat_id) {
            // echo "SELECT *, jobs.feature AS feature FROM `job_cat`,`jobs` WHERE job_cat.cat_id = '$cat_id' AND jobs.j_id = job_cat.j_id ";
            $sql4 = query_check($conn,"SELECT *, jobs.feature AS feature FROM `job_cat`,`jobs` WHERE job_cat.cat_id = '$cat_id' AND jobs.j_id = job_cat.j_id ");
            $row4 = mysqli_fetch_assoc($sql4);
            if (!empty($row4)) {
                do {
                    $cj_id = $row4['j_id'];
                    if ($row4['feature'] == 1) {
                        $c_jobs['a'.$z] = $cj_id;
                    }else{
                        $c_jobs['b'.$z] = $cj_id;
                    }
                    $z++;
                } while ($row4 = mysqli_fetch_assoc($sql4));
            }
        }
    }
    if (isset($_REQUEST['arb_id'])) {
        $arb_ids =$_REQUEST['arb_id'];
        foreach ($arb_ids as $arb_id) {
            $sql4 = query_check($conn,"SELECT *, jobs.feature AS feature FROM `job_arb`,`jobs` WHERE `arb_id` = '$arb_id' AND jobs.j_id = job_arb.j_id ");
            $row4 = mysqli_fetch_assoc($sql4);
            if (!empty($row4)) {
                do {
                    $aj_id = $row4['j_id'];
                    if ($row4['feature'] == 1) {
                        $a_jobs['a'.$z] = $aj_id;
                    }else{
                        $a_jobs['b'.$z] = $aj_id;
                    }
                    $z++;
                } while ($row4 = mysqli_fetch_assoc($sql4));
            }
        }
    }
    if (isset($_REQUEST['sort_id'])) {
        $sort_ids =$_REQUEST['sort_id'];
        foreach ($sort_ids as $sort_id) {
            $sql4 = query_check($conn,"SELECT *, jobs.feature AS feature FROM `job_sort`,`jobs` WHERE `sort_id` = '$sort_id' AND jobs.j_id = job_sort.j_id ");
            $row4 = mysqli_fetch_assoc($sql4);
            if (!empty($row4)) {
                do {
                    $sj_id = $row4['j_id'];
                    if ($row4['feature'] == 1) {
                        $s_jobs['a'.$z] = $sj_id;
                    }else{
                        $s_jobs['b'.$z] = $sj_id;
                    }
                    $z++;
                } while ($row4 = mysqli_fetch_assoc($sql4));
            }
        }
    }

    if (!isset($_REQUEST['cat_id']) && isset($_REQUEST['arb_id']) && isset($_REQUEST['sort_id'])) {
        $jobs = array_intersect($s_jobs,$a_jobs);
    }elseif (isset($_REQUEST['cat_id']) && !isset($_REQUEST['arb_id']) && isset($_REQUEST['sort_id'])) {
        $jobs = array_intersect($s_jobs,$c_jobs);
    }elseif (isset($_REQUEST['cat_id']) && isset($_REQUEST['arb_id']) && !isset($_REQUEST['sort_id'])) {
        $jobs = array_intersect($c_jobs,$a_jobs);
    }elseif (isset($_REQUEST['cat_id']) && isset($_REQUEST['arb_id']) && isset($_REQUEST['sort_id'])) {
        $jobs = array_intersect($c_jobs,$s_jobs,$a_jobs);
    } else{
        $jobs = array_merge($c_jobs, $a_jobs, $s_jobs);
    }
    $jobs = array_unique($jobs);
    ksort($jobs);
    // print_r($c_jobs);
    // echo "<br>";
    // print_r($a_jobs);
    // echo "<br>";
    // print_r($s_jobs);
    // echo "<br>";
    // print_r($jobs);
    if (empty($jobs)) {
        $show = '<div class="notification error closeable">No jobs present!</div>';
    }else{
        $z = 0;
        $feat = 0;
        if (isset($_REQUEST['q'])) {
            $q = $_REQUEST['q'];
            $q_attach = ' AND (`title` LIKE \'%'.$q.'%\' OR `job_desc` LIKE \'%".$q."%\')';
        }else{
            $q = '';
            $q_attach = '';
        }
        if (!isset ($_REQUEST['page']) ) {
            $page = 1;
        } else {
            $page = $_REQUEST['page'];
        }
        $results_per_page = 10;
        $page_first_result = ($page-1) * $results_per_page;
        $number_of_result = sizeof($jobs);
        $number_of_page = ceil ($number_of_result / $results_per_page);
        $jobs = array_values($jobs);
        $jobs = array_slice($jobs, $page_first_result, $page_first_result+$results_per_page);
        // print_r($jobs);
        foreach ($jobs as $job) {
            $sql10 = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` = '$job' ".$q_attach." ORDER BY `feature` DESC, `j_id` DESC");
            $row10 = mysqli_fetch_assoc($sql10);
            $feat = $row10['feature'];
        }
        foreach ($jobs as $job) {

            // echo "SELECT * FROM `jobs` WHERE `j_id` = '$job' AND `status` = 1 ".$q_attach."  ORDER BY `feature` DESC";
                $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` = '$job' AND `status` = 1 ".$q_attach."  ORDER BY `feature` DESC, `j_id` DESC");
                $row = mysqli_fetch_assoc($sql);
            $c_id = $row['c_id'];
                $sql9 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id' AND `status` = 1 ");
                $row9 = mysqli_fetch_assoc($sql9);
                if ($row9['status'] == 1) {

                $j_id = $row['j_id'];
                $category = '';
                $sql11 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
                $row11 = mysqli_fetch_assoc($sql11);
                $j = 1;
                if (!empty($row11)) {
                    do {
                        $cat_id = $row11['cat_id'];
                        if ($j == 1) {
                            $comma = "";
                        }else {
                            $comma = ", ";
                        }
                        $sql12 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                        $row12 = mysqli_fetch_assoc($sql12);
                        if (!empty($row12)) {
                            $category .= $comma.$row12['category'];
                            $j++;
                        }
                    } while ($row11 = mysqli_fetch_assoc($sql11));
                }
                $arbeitszeit = '';
                $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
                $row21 = mysqli_fetch_assoc($sql21);
                $k = 1;
                if (!empty($row21)) {
                    do {
                        $arb_id = $row21['arb_id'];
                        if ($k == 1) {
                            $comma = "";
                        }else {
                            $comma = ", ";
                        }
                        $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                        $row22 = mysqli_fetch_assoc($sql22);
                        if (!empty($row22)) {
                            $arbeitszeit .= $comma.$row22['arbeitszeit'];
                            $k++;
                        }
                    } while ($row21 = mysqli_fetch_assoc($sql21));
                }

            $arbeitsort = '';
            $sql3_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row3_1 = mysqli_fetch_assoc($sql3_1);
            $k = 1;
            if (!empty($row3_1)) {
                do {
                    $sort_id = $row3_1['sort_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql3_2 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row3_2 = mysqli_fetch_assoc($sql3_2);
                    if (!empty($row3_2)) {
                        $arbeitsort .= $comma.$row3_2['arbeitsort'];
                        $k++;
                    }
                } while ($row3_1 = mysqli_fetch_assoc($sql3_1));
            }

                $c_id = $row['c_id'];
                $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
                $row1 = mysqli_fetch_assoc($sql1);

                $logo = '';
                if (!empty($row1['c_logo'])) {
                    $logo = '<img src="dashboard/logos/'.$row1['c_logo'].'" alt="Firmen Logo">';
                }else{
                    $logo = '<img src="dashboard/logos/placeholder.jpg" alt="Firmen Logo">';
                }


            $arb_atch = $sort_atch = $cat_atch = '';
                if (!empty($arbeitszeit)) {
                    $arb_atch = '<li><i class="icon-material-outline-business-center"></i> '.$arbeitszeit.'</li>';
                }
                if (!empty($category)) {
                    $cat_atch = '<li><i class="icon-material-outline-bookmarks"></i> '.$category.'</li>';
                }
                if (!empty($arbeitsort)) {
                    $sort_atch = '<li><i class="icon-material-outline-location-on"></i> '.$arbeitsort.'</li>';
                }
                $featured = '';
            if ($row['feature'] == 1) {
                $featured = ' bookmarked';
            }

            $page_links = '';
            for($i = 1; $i<= $number_of_page; $i++) {
                $active = '';
                if ($i == $page) {
                    $active = 'class="current-page"';
                }
                $page_links .= '<li><a href="suche.php?'.$new_query_string = http_build_query(array_merge($_GET,array('page' => $i))).'" '.$active.'>'.$i.'</a></li>';
            }
                $show .= '<a href="job.php?j_id='.$row['j_id'].'" class="job-listing">

                <!-- Job Listing Details -->
                <div class="job-listing-details">

                    <!-- Logo -->
                    <div class="job-listing-company-logo">
                    '.$logo.'
                    </div>

                    <!-- Details -->
                    <div class="job-listing-description">
                        <h3 class="job-listing-title">'.$row['title'].'</h3>

                        <!-- Job Listing Footer -->
                        <div class="job-listing-footer">
                            <ul>
                            <li><i class="icon-material-outline-business"></i> '.$row1['company'].'
                                <div class="verified-badge" title="Premium Arbeitgeber" data-tippy-placement="top"></div>
                            </li>
                            '.$arb_atch.$cat_atch.$sort_atch.'
                            <li><i class="icon-material-outline-access-time"></i> '.date('j.n.Y',strtotime($row['date'])).'</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bookmark -->
                    <span class="bookmark-icon'.$featured.'" title="Premium Job"></span>
                </div>
            </a>';

                }
        }
    }

    return array($show,$show1,$page_links);
}
function moveElement(&$array, $a, $b) {
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
}


function show_jobs_all($conn,$c_id1,$cat_id1, $arb_id1, $sort_id1)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 ORDER BY `feature` DESC");
    if ($c_id1 != 0) {
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND `c_id` = '$c_id1' ORDER BY `feature` DESC");
    }elseif ($cat_id1 != 0) {
        $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND `c_id` = '$cat_id1' ORDER BY `feature` DESC");
    }
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $c_id = $row['c_id'];
            $sql9 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id' AND `status` = 1 ");
            $row9 = mysqli_fetch_assoc($sql9);
            if ($row9['status'] == 1) {
                $featured = '';
            if ($row['feature'] == 1) {
                $featured = '<div class="pb-2">
                <span class="badge bg-success"><i class="fa fa-diamond"></i> Featured</span>
            </div>';
            }

            $j_id = $row['j_id'];
            $category = '';
            $sql11 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row11 = mysqli_fetch_assoc($sql11);
            $j = 1;
            if (!empty($row11)) {
                do {
                    $cat_id = $row11['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql12 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row12 = mysqli_fetch_assoc($sql12);
                    if (!empty($row12)) {
                        $category .= $comma.$row12['category'];
                        $j++;
                    }
                } while ($row11 = mysqli_fetch_assoc($sql11));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }


            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row1 = mysqli_fetch_assoc($sql1);
            $show .= '<div class="col-md-6 p-2">
                        <div class="card h-100">
                            <div class="card-body text-start">

                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">'.$row['title'].'</h5><span class="text-secondary semibold date">'.date('d-M-Y',strtotime($row['date'])).'</span>
                                </div>
                                <div class="my-2">
                                    <p class="mb-0">
                                        <span class="semibold">Kategorie:</span> <span class="semibold text-success">'.$category.'</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="semibold">Arbeitszeit:</span> <span class="semibold text-info">'.$arbeitszeit.'</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="semibold">Firma:</span> <a href="company_details.php?c_id='.$c_id.'"><span class="semibold text-primary">'.$row1['company'].'</span></a>
                                    </p>
                                    <p class="mb-0">
                                        <span class="semibold">Bewerbungsfrist:</span> <span class="semibold text-danger">'.date('Y-m-d', strtotime($row['end_date'])).'</span>
                                    </p>
                                </div>
                                <a href="job.php?j_id='.$row['j_id'].'" class="btn btn-primary">Job Details</a>
                            </div>
                        </div>
                    </div>';
            }
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
    }
    return $show;
}
function show_company_jobs($c_id,$conn)
{
    $show = $show1 = '';
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND `c_id` = '$c_id' ORDER BY `feature`,`c_id` DESC");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $featured = '';
            $j_id = $row['j_id'];
            $category = '';
            $sql11 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row11 = mysqli_fetch_assoc($sql11);
            $j = 1;
            if (!empty($row11)) {
                do {
                    $cat_id = $row11['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql12 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row12 = mysqli_fetch_assoc($sql12);
                    if (!empty($row12)) {
                        $category .= $comma.$row12['category'];
                        $j++;
                    }
                } while ($row11 = mysqli_fetch_assoc($sql11));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }


            $arbeitsort = '';
            $sql3_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row3_1 = mysqli_fetch_assoc($sql3_1);
            $k = 1;
            if (!empty($row3_1)) {
                do {
                    $sort_id = $row3_1['sort_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql3_2 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row3_2 = mysqli_fetch_assoc($sql3_2);
                    if (!empty($row3_2)) {
                        $arbeitsort .= $comma.$row3_2['arbeitsort'];
                        $k++;
                    }
                } while ($row3_1 = mysqli_fetch_assoc($sql3_1));
            }

            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row1 = mysqli_fetch_assoc($sql1);
            if (!empty($row1['c_logo'])) {
                $img = '<img src="dashboard/logos/'.$row1['c_logo'].'"  alt="Firma Logo" style="max-height:100px;">';
            }else{
                $img = '';
            }

            if ($row['feature'] == 1) {
                $show1 .= '
                    <a href="job.php?j_id='.$row['j_id'].'" class="job-listing">

						<!-- Job Listing Details -->
						<div class="job-listing-details">

							<!-- Details -->
							<div class="job-listing-description">
								<h3 class="job-listing-title">'.$row['title'].'</h3>


							</div>

						</div>

						<!-- Bookmark -->
						<span class="bookmark-icon"></span>
					</a>';
            }else{
                $show .= '
                <a href="job.php?j_id='.$row['j_id'].'" class="job-listing">

                    <!-- Job Listing Details -->
                    <div class="job-listing-details">

                        <!-- Details -->
                        <div class="job-listing-description">
                            <h3 class="job-listing-title">'.$row['title'].'</h3>


                        </div>

                    </div>

                    <!-- Bookmark -->
                    <span class="bookmark-icon"></span>
                </a>';
            }

        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '';
        $show1 = '';
    }
    return array($show,$show1);
}
function show_category_jobs($conn)
{
    $show = $show1 = '';
    $cat_id = mysqli_real_escape_string($conn,$_REQUEST['cat_id1']);

    $sql4 = query_check($conn,"SELECT * FROM `job_cat` WHERE `cat_id` = '$cat_id' ");
    $row4 = mysqli_fetch_assoc($sql4);
    if (!empty($row4)) {
        do {
            $j_id = $row4['j_id'];
            $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND `j_id` = '$j_id' ORDER BY `feature` DESC");
            $row = mysqli_fetch_assoc($sql);
            if (!empty($row)) {

            $featured = '';
            $j_id = $row['j_id'];
            $category = '';
            $sql11 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row11 = mysqli_fetch_assoc($sql11);
            $j = 1;
            if (!empty($row11)) {
                do {
                    $cat_id = $row11['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql12 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row12 = mysqli_fetch_assoc($sql12);
                    if (!empty($row12)) {
                        $category .= $comma.$row12['category'];
                        $j++;
                    }
                } while ($row11 = mysqli_fetch_assoc($sql11));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }


            $arbeitsort = '';
            $sql3_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row3_1 = mysqli_fetch_assoc($sql3_1);
            $k = 1;
            if (!empty($row3_1)) {
                do {
                    $sort_id = $row3_1['sort_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql3_2 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row3_2 = mysqli_fetch_assoc($sql3_2);
                    if (!empty($row3_2)) {
                        $arbeitsort .= $comma.$row3_2['arbeitsort'];
                        $k++;
                    }
                } while ($row3_1 = mysqli_fetch_assoc($sql3_1));
            }

            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row1 = mysqli_fetch_assoc($sql1);
            if (!empty($row1['c_logo'])) {
                $img = '<img src="dashboard/logos/'.$row1['c_logo'].'"  alt="Firma Logo" style="max-height:100px;">';
            }else{
                $img = '';
            }

            if ($row['feature'] == 1) {
                $show1 .= '

                        <a href="job.php?j_id='.$row['j_id'].'" class="job-listing with-apply-button">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">

                                        <!-- Logo -->
                                        <div class="job-listing-company-logo">
                                            '.$img.'
                                        </div>

                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">'.$row['title'].'</h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li><i class="icon-material-outline-business"></i> '.$row1['company'].'
                                                        <div class="verified-badge" title="Premium Arbeitgeber" data-tippy-placement="top"></div>
                                                    </li>
                                                    <li><i class="icon-material-outline-location-on"></i> '.nl2br($arbeitsort).'</li>
                                                    <li><i class="icon-material-outline-business-center"></i> '.$arbeitszeit.'</li>
                                                    <li><i class="icon-material-outline-access-time"></i> '.date('j.n.Y',strtotime($row['date'])).'</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Apply Button -->
                                        <span class="list-apply-button ripple-effect">Job Details</span>
                                    </div>
                                </a>';
            }else{
                $show .= '

                        <a href="job.php?j_id='.$row['j_id'].'" class="job-listing with-apply-button">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">

                                        <!-- Logo -->
                                        <div class="job-listing-company-logo">
                                            '.$img.'
                                        </div>

                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">'.$row['title'].'</h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li><i class="icon-material-outline-business"></i> '.$row1['company'].'
                                                        <div class="verified-badge" title="Premium Arbeitgeber" data-tippy-placement="top"></div>
                                                    </li>
                                                    <li><i class="icon-material-outline-location-on"></i> '.nl2br($arbeitsort).'</li>
                                                    <li><i class="icon-material-outline-business-center"></i> '.$arbeitszeit.'</li>
                                                    <li><i class="icon-material-outline-access-time"></i> '.date('j.n.Y',strtotime($row['date'])).'</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Apply Button -->
                                        <span class="list-apply-button ripple-effect">Job Details</span>
                                    </div>
                                </a>';
            }
            }
        } while ($row4 = mysqli_fetch_assoc($sql4));
    } else {
        $show1 = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
        $show = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
    }
    return array($show,$show1);
}


function show_place_jobs($conn)
{
    $show = '';

    $place = mysqli_real_escape_string($conn,$_REQUEST['place']);
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND `arbeitsort` = '$place' ORDER BY `feature` DESC");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $featured = '';
            if ($row['feature'] == 1) {
                $featured = '<div class="pb-2">
                <span class="badge bg-success"><i class="fa fa-diamond"></i> Featured</span>
            </div>';
            }

            $j_id = $row['j_id'];
            $category = '';
            $sql11 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row11 = mysqli_fetch_assoc($sql11);
            $j = 1;
            if (!empty($row11)) {
                do {
                    $cat_id = $row11['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql12 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row12 = mysqli_fetch_assoc($sql12);
                    if (!empty($row12)) {
                        $category .= $comma.$row12['category'];
                        $j++;
                    }
                } while ($row11 = mysqli_fetch_assoc($sql11));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }


            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row1 = mysqli_fetch_assoc($sql1);
            $show .= '<div class="col-md-6 p-2">
                        <div class="card h-100">
                            <div class="card-body text-start">

                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">'.$row['title'].'</h5><span class="text-secondary semibold date">'.date('d-M-Y',strtotime($row['date'])).'</span>
                                </div>
                                <div class="my-2">
                                    <p class="mb-0">
                                        <span class="semibold">Kategorie:</span> <span class="semibold text-success">'.$category.'</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="semibold">Arbeitszeit:</span> <span class="semibold text-info">'.$arbeitszeit.'</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="semibold">Firma:</span> <a href="company_details.php?c_id='.$c_id.'"><span class="semibold text-primary">'.$row1['company'].'</span></a>
                                    </p>
                                    <p class="mb-0">
                                        <span class="semibold">Bewerbungsfrist:</span> <span class="semibold text-danger">'.date('Y-m-d', strtotime($row['end_date'])).'</span>
                                    </p>
                                </div>
                                <a href="job.php?j_id='.$row['j_id'].'" class="btn btn-primary">Job Details</a>
                            </div>
                        </div>
                    </div>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
    }
    return $show;
}

function show_arbeitszeit_jobs($conn)
{
    $show = $show1 = '';
    $arb_id = mysqli_real_escape_string($conn,$_REQUEST['arb_id1']);

    $sql4 = query_check($conn,"SELECT * FROM `job_arb` WHERE `arb_id` = '$arb_id' ");
    $row4 = mysqli_fetch_assoc($sql4);
    if (!empty($row4)) {
        do {
            // echo 1;
            $j_id = $row4['j_id'];
            $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND `j_id` = '$j_id' ORDER BY `feature` DESC");
            $row = mysqli_fetch_assoc($sql);
            if (!empty($row)) {

            $featured = '';
            $j_id = $row['j_id'];
            $category = '';
            $sql3 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row3 = mysqli_fetch_assoc($sql3);
            $j = 1;
            if (!empty($row3)) {
                do {
                    $cat_id = $row3['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql2 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row2 = mysqli_fetch_assoc($sql2);
                    if (!empty($row2)) {
                        $category .= $comma.$row2['category'];
                        $j++;
                    }
                } while ($row3 = mysqli_fetch_assoc($sql3));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }

            $arbeitsort = '';
            $sql3_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row3_1 = mysqli_fetch_assoc($sql3_1);
            $k = 1;
            if (!empty($row3_1)) {
                do {
                    $sort_id = $row3_1['sort_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql3_2 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row3_2 = mysqli_fetch_assoc($sql3_2);
                    if (!empty($row3_2)) {
                        $arbeitsort .= $comma.$row3_2['arbeitsort'];
                        $k++;
                    }
                } while ($row3_1 = mysqli_fetch_assoc($sql3_1));
            }

            $c_id = $row['c_id'];
            $sql2 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row2 = mysqli_fetch_assoc($sql2);
            if (!empty($row2['c_logo'])) {
                $img = '<img src="dashboard/logos/'.$row2['c_logo'].'"  alt="Firma Logo" style="max-height:100px;">';
            }else{
                $img = '';
            }

            if ($row['feature'] == 1) {
                $show1 .= '
                <div class="col-md-6 p-2">
                    <div class="card h-100">
                        <div class="text-center p-2">
                        '.$img.'
                        </div>
                        <div class="card-body">
                        <a href="job.php?j_id='.$row['j_id'].'" class="card-link"><h5 class="card-title text-center">'.$row['title'].'</h5></a>
                        </div>
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item"><span class="semibold">Firma:</span> <a href="company_details.php?c_id='.$c_id.'"><span class="semibold text-primary">'.$row2['company'].'</span></a></li>
                        <li class="list-group-item"><span class="semibold">Arbeitsort:</span> <span class="semibold text-secondary">'.nl2br($arbeitsort).'</span></li>
                            <li class="list-group-item"><span class="semibold">Kategorie:</span> <span class="semibold text-secondary">'.$category.'</span></li>
                            <li class="list-group-item"><span class="semibold">Arbeitszeit:</span> <span class="semibold text-secondary">'.$arbeitszeit.'</span></li>
                            <li class="list-group-item"><span class="semibold">Erstellt:<span class="text-secondary semibold"> '.date('j.n.Y',strtotime($row['date'])).'</span></li>
                            <!---- <li class="list-group-item"><span class="semibold">Bewerbungsfrist:</span> <span class="semibold text-danger"> '.date('Y-m-d', strtotime($row['end_date'])).'</span></li> ---->
                        </ul>
                    </div>
                </div>';
            }else{
                $show .= '
                    <div class="col-md-6 p-2">
                        <div class="card h-100">
                            <div class="text-center p-2">
                            '.$img.'
                            </div>
                            <div class="card-body">
                            <a href="job.php?j_id='.$row['j_id'].'" class="card-link"><h5 class="card-title text-center">'.$row['title'].'</h5></a>
                            </div>
                            <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="semibold">Firma:</span> <a href="company_details.php?c_id='.$c_id.'"><span class="semibold text-primary">'.$row2['company'].'</span></a></li>
                            <li class="list-group-item"><span class="semibold">Arbeitsort:</span> <span class="semibold text-secondary">'.nl2br($arbeitsort).'</span></li>
                                <li class="list-group-item"><span class="semibold">Kategorie:</span> <span class="semibold text-secondary">'.$category.'</span></li>
                                <li class="list-group-item"><span class="semibold">Arbeitszeit:</span> <span class="semibold text-secondary">'.$arbeitszeit.'</span></li>
                                <li class="list-group-item"><span class="semibold">Erstellt:<span class="text-secondary semibold"> '.date('j.n.Y',strtotime($row['date'])).'</span></li>
                                <!---- <li class="list-group-item"><span class="semibold">Bewerbungsfrist:</span> <span class="semibold text-danger"> '.date('Y-m-d', strtotime($row['end_date'])).'</span></li> ---->
                            </ul>
                        </div>
                    </div>';
            }

            }
        } while ($row4 = mysqli_fetch_assoc($sql4));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
        $show1 = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
    }
    return array($show,$show1);
}


function show_arbeitsort_jobs($conn)
{
    $show = $show1 = '';
    $sort_id = mysqli_real_escape_string($conn,$_REQUEST['sort_id1']);

    $sql4 = query_check($conn,"SELECT * FROM `job_sort` WHERE `sort_id` = '$sort_id' ");
    $row4 = mysqli_fetch_assoc($sql4);
    if (!empty($row4)) {
        do {
            // echo 1;
            $j_id = $row4['j_id'];
            $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `status` = 1 AND `j_id` = '$j_id' ORDER BY `feature` DESC");
            $row = mysqli_fetch_assoc($sql);
            if (!empty($row)) {
            $featured = '';
            $j_id = $row['j_id'];
            $category = '';
            $sql3 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' GROUP BY `cat_id`");
            $row3 = mysqli_fetch_assoc($sql3);
            $j = 1;
            if (!empty($row3)) {
                do {
                    $cat_id = $row3['cat_id'];
                    if ($j == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql2 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
                    $row2 = mysqli_fetch_assoc($sql2);
                    if (!empty($row2)) {
                        $category .= $comma.$row2['category'];
                        $j++;
                    }
                } while ($row3 = mysqli_fetch_assoc($sql3));
            }
            $arbeitszeit = '';
            $sql21 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' GROUP BY `arb_id`");
            $row21 = mysqli_fetch_assoc($sql21);
            $k = 1;
            if (!empty($row21)) {
                do {
                    $arb_id = $row21['arb_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql22 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
                    $row22 = mysqli_fetch_assoc($sql22);
                    if (!empty($row22)) {
                        $arbeitszeit .= $comma.$row22['arbeitszeit'];
                        $k++;
                    }
                } while ($row21 = mysqli_fetch_assoc($sql21));
            }


            $arbeitsort = '';
            $sql3_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' GROUP BY `sort_id`");
            $row3_1 = mysqli_fetch_assoc($sql3_1);
            $k = 1;
            if (!empty($row3_1)) {
                do {
                    $sort_id = $row3_1['sort_id'];
                    if ($k == 1) {
                        $comma = "";
                    }else {
                        $comma = ", ";
                    }
                    $sql3_2 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
                    $row3_2 = mysqli_fetch_assoc($sql3_2);
                    if (!empty($row3_2)) {
                        $arbeitsort .= $comma.$row3_2['arbeitsort'];
                        $k++;
                    }
                } while ($row3_1 = mysqli_fetch_assoc($sql3_1));
            }
            $c_id = $row['c_id'];
            $sql2 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
            $row2 = mysqli_fetch_assoc($sql2);
            if (!empty($row2['c_logo'])) {
                $img = '<img src="dashboard/logos/'.$row2['c_logo'].'"  alt="Firma Logo" style="max-height:100px;">';
            }else{
                $img = '';
            }

            if ($row['feature'] == 1) {
                $show1 .= '
                        <div class="col-md-6 p-2">
                            <div class="card h-100">
                                <div class="text-center p-2">
                                '.$img.'
                                </div>
                                <div class="card-body">
                                <a href="job.php?j_id='.$row['j_id'].'" class="card-link"><h5 class="card-title text-center">'.$row['title'].'</h5></a>
                                </div>
                                <ul class="list-group list-group-flush">
                                <li class="list-group-item"><span class="semibold">Firma:</span> <a href="company_details.php?c_id='.$c_id.'"><span class="semibold text-primary">'.$row2['company'].'</span></a></li>
                                <li class="list-group-item"><span class="semibold">Arbeitsort:</span> <span class="semibold text-secondary">'.nl2br($arbeitsort).'</span></li>
                                    <li class="list-group-item"><span class="semibold">Kategorie:</span> <span class="semibold text-secondary">'.$category.'</span></li>
                                    <li class="list-group-item"><span class="semibold">Arbeitszeit:</span> <span class="semibold text-secondary">'.$arbeitszeit.'</span></li>
                                    <li class="list-group-item"><span class="semibold">Erstellt:<span class="text-secondary semibold"> '.date('j.n.Y',strtotime($row['date'])).'</span></li>
                                    <!---- <li class="list-group-item"><span class="semibold">Bewerbungsfrist:</span> <span class="semibold text-danger"> '.date('Y-m-d', strtotime($row['end_date'])).'</span></li> ---->
                                </ul>
                            </div>
                        </div>';
            }else{
                $show .= '
                        <div class="col-md-6 p-2">
                            <div class="card h-100">
                                <div class="text-center p-2">
                                '.$img.'
                                </div>
                                <div class="card-body">
                                <a href="job.php?j_id='.$row['j_id'].'" class="card-link"><h5 class="card-title text-center">'.$row['title'].'</h5></a>
                                </div>
                                <ul class="list-group list-group-flush">
                                <li class="list-group-item"><span class="semibold">Firma:</span> <a href="company_details.php?c_id='.$c_id.'"><span class="semibold text-primary">'.$row2['company'].'</span></a></li>
                                <li class="list-group-item"><span class="semibold">Arbeitsort:</span> <span class="semibold text-secondary">'.nl2br($arbeitsort).'</span></li>
                                    <li class="list-group-item"><span class="semibold">Kategorie:</span> <span class="semibold text-secondary">'.$category.'</span></li>
                                    <li class="list-group-item"><span class="semibold">Arbeitszeit:</span> <span class="semibold text-secondary">'.$arbeitszeit.'</span></li>
                                    <li class="list-group-item"><span class="semibold">Erstellt:<span class="text-secondary semibold"> '.date('j.n.Y',strtotime($row['date'])).'</span></li>
                                    <!---- <li class="list-group-item"><span class="semibold">Bewerbungsfrist:</span> <span class="semibold text-danger"> '.date('Y-m-d', strtotime($row['end_date'])).'</span></li> ---->
                                </ul>
                            </div>
                        </div>';
            }
            }
        } while ($row4 = mysqli_fetch_assoc($sql4));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
        $show1 = '<tr><td colspan="7"><div class="notification error closeable">No jobs present!</div></td></tr>';
    }
    return array($show,$show1);
}


function show_company($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `company` WHERE `c_id` > 0 AND `status` = 1 ORDER BY `feature` DESC");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {

            $featured = '';
            if ($row['feature'] == 1) {
                $featured = ' ';
            }else{
                $featured = '';
            }
            $logo = '';
            if (!empty($row['c_logo'])) {
                $logo = '<img src="dashboard/logos/'.$row['c_logo'].'" alt="Firmen Logo">';
            }else{
                $logo = '<img src="dashboard/logos/placeholder.jpg" alt="Firmen Logo">';
            }
            $show .= '
                    <a href="arbeitgeber.php?c_id='.$row['c_id'].'" class="company">
					<div class="company-inner-alignment">
						<span class="company-logo">'.$logo.'</span>
						<h4>'.$row['company'].'</h4>
						<!-- <div class="star-rating" data-rating="3.5"></div> -->
					</div>
				</a>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '
        <a href="#" class="company">
        <div class="company-inner-alignment">
            <span class="company-logo"><img src="dashboard/logos/placeholder.jpg" alt="Firmen Logo"></span>
            <h4>No Company Present</h4>
            <div class="star-rating" data-rating="3.5"></div>
        </div>
    </a>';
    }
    return $show;
}


function admin_login($conn)
{
    $show = '';
    $username = mysqli_real_escape_string($conn,$_REQUEST['username']);
    $password = md5($_REQUEST['password']);
    $sql = query_check($conn,"SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$password'");
    $row = mysqli_fetch_assoc($sql);
    if (mysqli_num_rows($sql) > 0) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['role'] = $row['role'];
        $show = '<div class="notification success closeable">Logged In!</div>';
        header('location:index.php');
    } else {
        $show = '<div class="notification error closeable">Incorrect username OR password!</div>';
    }
    return $show;
}
function dlt_job($conn)
{
    $show = '';
    $dlt_id = mysqli_real_escape_string($conn,$_REQUEST['dlt_id']);
    // echo "DELETE FROM `jobs` WHERE `j_id` = '$dlt_id'";
    $sql = query_check($conn,"DELETE FROM `jobs` WHERE `j_id` = '$dlt_id'");
    if ($sql) {
        $sql1 = query_check($conn,"DELETE FROM `job_cat` WHERE `j_id` = '$dlt_id'");
        $sql2 = query_check($conn,"DELETE FROM `job_arb` WHERE `j_id` = '$dlt_id'");
        $sql3 = query_check($conn,"DELETE FROM `job_sort` WHERE `j_id` = '$dlt_id'");
        $show = '<div class="notification success closeable">Job deleted successfully!</div>';
        header('refresh:3,url=index.php');
    } else {
        $show = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $show;
}


function change_status($conn)
{
  $info1 = "";
  $j_id = $_REQUEST['j_id'];
  $feature = $_GET['feature'];
  $sql = "UPDATE `jobs` SET `feature` = '$feature' WHERE `j_id` = '$j_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Job Status Changed!</div>';
    header('refresh:3,url=index.php');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}
function change_status1($conn)
{
  $info1 = "";
  $j_id = $_REQUEST['j_id'];
  $status = $_GET['status'];
  $sql = "UPDATE `jobs` SET `status` = '$status' WHERE `j_id` = '$j_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Job Status Changed!</div>';
    header('refresh:3,url=index.php');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}

function change_status2($conn)
{
  $info1 = "";
  $c_id = $_REQUEST['c_id'];
  $status = $_GET['status'];
  $sql = "UPDATE `company` SET `status` = '$status' WHERE `c_id` = '$c_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Company Status Changed!</div>';
    header('refresh:3,url=company.php');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}

function change_status3($conn)
{
  $info1 = "";
  $c_id = $_REQUEST['c_id'];
  $feature = $_GET['feature'];
  $sql = "UPDATE `company` SET `feature` = '$feature' WHERE `c_id` = '$c_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Company Status Changed!</div>';
    header('refresh:3,url=company.php');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}


function show_edit_job($conn)
{
    $show = '';
    $j_id = mysqli_real_escape_string($conn,$_REQUEST['j_id']);
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` = '$j_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {

        do {
            $select = '';
            $company = '';
            $category = '';
            $arbeitszeit = '';
            $c_id = $row['c_id'];
            $sql1 = query_check($conn,"SELECT * FROM `company` WHERE `c_id` > 0");
            $row1 = mysqli_fetch_assoc($sql1);
            do {
                if ($c_id === $row1['c_id']) {
                   $select = 'selected';
                }else {
                    $select = '';
                }
                $company .= '<option value="'.$row1['c_id'].'" '.$select.'>'.$row1['c_id'].' - '.$row1['company'].'</option>';
            } while ($row1 = mysqli_fetch_assoc($sql1));



                $sql4 = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` > 0");
                $row4 = mysqli_fetch_assoc($sql4);
                $i = 1;
                if (!empty($row4)) {
                    do {

                        $a_select = '';
                        $arb_id = $row4['arb_id'];
                        $sql3 = query_check($conn,"SELECT * FROM `job_arb` WHERE `j_id` = '$j_id' AND `arb_id` = '$arb_id'");
                        $row3 = mysqli_fetch_assoc($sql3);
                        if ($row3['arb_id'] == $arb_id) {
                            $a_select = 'checked';
                        }else {
                            $a_select = '';
                        }
                        $arbeitszeit .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox" id="a_check'.$i.'" name="arb_id[]" value="'.$row4['arb_id'].'" '.$a_select.'>
                        <label class="form-check-label" for="a_check'.$i.'">
                            '.$row4['arbeitszeit'].'
                        </label>
                    </div>';
                    $i++;
                    } while ($row4 = mysqli_fetch_assoc($sql4));
                } else {
                    $arbeitszeit = '<div class="form-check">
                    <input class="form-check-input" type="checkbox" id="a_check'.$i.'" name="cat_id[]" value="" disabled>
                    <label class="form-check-label" for="a_check'.$i.'">
                        No Arbeitszeit Present
                    </label>
                </div>';
                }



                $sql5 = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` > 0");
                $row5 = mysqli_fetch_assoc($sql5);
                $i = 1;
                if (!empty($row5)) {
                    do {

                        $c_select = '';
                        $cat_id = $row5['cat_id'];
                        $sql6 = query_check($conn,"SELECT * FROM `job_cat` WHERE `j_id` = '$j_id' AND `cat_id` = '$cat_id'");
                        $row6 = mysqli_fetch_assoc($sql6);
                        if ($row6['cat_id'] == $cat_id) {
                            $c_select = 'checked';
                        }else {
                            $c_select = '';
                        }
                        $category .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox" id="c_check'.$i.'" name="cat_id[]" value="'.$row5['cat_id'].'" '.$c_select.'>
                        <label class="form-check-label" for="c_check'.$i.'">
                            '.$row5['category'].'
                        </label>
                    </div>';
                    $i++;
                    } while ($row5 = mysqli_fetch_assoc($sql5));
                } else {
                    $category = '<div class="form-check">
                    <input class="form-check-input" type="checkbox" id="c_check'.$i.'" name="cat_id[]" value="" disabled>
                    <label class="form-check-label" for="c_check'.$i.'">
                        No Arbeitszeit Present
                    </label>
                </div>';
                }
                $arbeitsort = '';

                $sql6 = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` > 0");
                $row6 = mysqli_fetch_assoc($sql6);
                $i = 1;
                if (!empty($row6)) {
                    do {

                        $s_select = '';
                        $sort_id = $row6['sort_id'];
                        $sql6_1 = query_check($conn,"SELECT * FROM `job_sort` WHERE `j_id` = '$j_id' AND `sort_id` = '$sort_id'");
                        $row6_1 = mysqli_fetch_assoc($sql6_1);
                        if ($row6_1['sort_id'] == $sort_id) {
                            $s_select = 'checked';
                        }else {
                            $s_select = '';
                        }
                        $arbeitsort .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sort_id[]" value="'.$row6['sort_id'].'" '.$s_select.'>
                        <label class="form-check-label" for="s_check'.$i.'">
                            '.$row6['arbeitsort'].'
                        </label>
                    </div>';
                    $i++;
                    } while ($row6 = mysqli_fetch_assoc($sql6));
                } else {
                    $arbeitsort = '<div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sort_id[]" value="" disabled>
                    <label class="form-check-label" for="s_check'.$i.'">
                        No Arbeitszeit Present
                    </label>
                </div>';
                }


            $show .= '
                            <form class="row g-3 needs-validation job-form" novalidate method="post">
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Job Titel</label>
                                    <input type="text" class="form-control" name="title"  id="input1" value="'.$row['title'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Category</label>
                                    <div class="card check-box p-2">
                                        '.$category.'
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Arbeitszeit</label>
                                    <div class="card check-box p-2">
                                        '.$arbeitszeit.'
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="input9" class="form-label">Arbeitsort</label>
                                    <div class="card check-box p-2">
                                        '.$arbeitsort.'
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="input4" class="form-label">Beschreibung</label>
                                    <textarea name="job_desc"  id="input4" rows="5" class="form-control editor">'.nl2br($row['job_desc']).'</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="input6" class="form-label">Bewerbungsformular </label>
                                    <input type="url" class="form-control" name="app_link"  id="input6" value="'.$row['app_link'].'">
                                </div>
                                <div class="col-md-4">
                                    <label for="input8" class="form-label">Erstellt</label>
                                    <input type="date" class="form-control" name="date"  id="input8" value="'.$row['date'].'">
                                </div>
                                <div class="col-md-4">
                                    <label for="input7" class="form-label">Bewerbungsfrist </label>
                                    <input type="date" class="form-control" name="end_date"  id="input7" value="'.$row['end_date'].'">
                                </div><div class="col-md-4">
                                <label for="input15" class="form-label">Job Start </label>
                                <input type="text" class="form-control" name="start"  id="input15" value="'.$row['start'].'">
                            </div>

                            <div class="col-12">
                                <label for="editor2" class="form-label">Bewerbung </label>
                                <textarea name="application"  id="editor2" rows="5" class="form-control editor">'.nl2br($row['application']).'</textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="editor3" class="form-label">Aufgabe </label>
                                <textarea name="aufgabe"  id="editor3" rows="5" class="form-control editor">'.nl2br($row['aufgabe']).'</textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="editor4" class="form-label">Anforderungen </label>
                                <textarea name="anforderungen"  id="editor4" rows="5" class="form-control editor">'.nl2br($row['anforderungen']).'</textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="editor5" class="form-label">Benefits</label>
                                <textarea name="benefits"  id="editor5" rows="5" class="form-control editor">'.nl2br($row['benefits']).'</textarea>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <label for="input17" class="form-label">Job Ansprechpartner </label>
                                <input type="text" class="form-control" name="contact_person"  id="input17"  value="'.$row['contact_person'].'">
                            </div>
                            <div class="col-md-4">
                                <label for="input18" class="form-label">Job Telefon</label>
                                <input type="text" class="form-control" name="telephone"  id="input18" value="'.$row['telephone'].'">
                            </div>
                            <div class="col-md-4">
                                <label for="input16" class="form-label">Job E-Mail </label>
                                <input type="text" class="form-control" name="email"  id="input16" value="'.$row['email'].'">
                            </div>
                                <div class="col-md-12">
                                    <label for="input91" class="form-label">Select Firma</label>
                                    <select name="c_id" id="input91" class="form-control">
                                        <option value="" selected disabled>Select a Firma</option>
                                        '.$company.'
                                    </select>
                                </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="edit_job">Update</button>
                            </div>
                        </form>';

                        $editor = '';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="notification error closeable">Job not present!</div>';
    }
    return array($show,$editor);
}

function show_edit_company($conn)
{
    $show = '';
    $c_id = mysqli_real_escape_string($conn,$_REQUEST['c_id']);
    $sql = query_check($conn,"SELECT * FROM `company` WHERE `c_id` = '$c_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '
        <form class="row g-3 needs-validation job-form" novalidate method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <label for="input5" class="form-label">Firma</label>
                                    <input type="text" class="form-control" name="company"  id="input5" value="'.$row['company'].'">
                                </div>
                                <div class="col-12">
                                    <label for="input7" class="form-label">Beschreibung</label>
                                    <textarea name="desc"  id="input7" rows="5" class="form-control editor2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="input6" class="form-label">Firmensitz</label>
                                    <input type="text" class="form-control" name="place"  id="input6" value="'.$row['place'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input8" class="form-label">Ansprechpartner </label>
                                    <input type="text" class="form-control" name="name"  id="input8"  value="'.$row['name'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input9" class="form-label">Karriereseite </label>
                                    <input type="url" class="form-control" name="apply"  id="input9" value="'.$row['apply'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input10" class="form-label">Telefon </label>
                                    <input type="tel" class="form-control" name="phone"  id="input10"  value="'.$row['phone'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input11" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email"  id="input11" value="'.$row['email'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input12" class="form-label">Webseite</label>
                                    <input type="url" class="form-control" name="website"  id="input12" value="'.$row['website'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input15" class="form-label">Instagram</label>
                                    <input type="url" class="form-control" name="instagram"  id="input15" value="'.$row['instagram'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input16" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" name="facebook"  id="input16" value="'.$row['facebook'].'">
                                </div>
                                <div class="col-md-6">
                                    <label for="input17" class="form-label">Youtube</label>
                                    <input type="url" class="form-control" name="youtube"  id="input17" value="'.$row['youtube'].'">
                                </div>
                                <div class="col-md-6">
                                    <div><img src="logos/'.$row['c_logo'].'" height="40"></div>
                                    <label for="input13" class="form-label">Logo</label>
                                    <input type="file" class="form-control" name="c_logo"  id="input13">
                                    <small class="text-muted">Leave this empty if you don\'t want to update logo</small>
                                </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="edit_company">Update</button>
                            </div>
                        </form>';
                        $editor = '<script>editor2.data.set("'.$row['desc'].'");</script>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="notification error closeable">Company not present!</div>';
    }
    return array($show,$editor);
}


function add_category($conn)
{
    $category = mysqli_real_escape_string($conn,$_REQUEST['category']);
    $desc = mysqli_real_escape_string($conn,$_REQUEST['desc']);

    $date = date('Y-m-d H:i:s');

    $sql = query_check($conn,"INSERT INTO `category` (`category`,`desc`,`date`)
    VALUES ('$category','$desc','$date')");
    if($sql){
        $info = '<div class="notification success closeable">Category Added Successfully!</div>';
        header("Refresh:2; url=add_category.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}

function ad_show_category($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<tr>
            <td>'.$row['cat_id'].'</td>
            <td>'.$row['category'].'</td>
            <td class="text-center">
                <select class="form-control" onchange="location = this.value;">
                    <option selected disabled>Select an action</option>
                    <option value="edit_category.php?cat_id='.$row['cat_id'].'" >Edit</option>
                    <option value="category.php?duplicate='.$row['cat_id'].'" >Duplicate</option>
                </select>
            </td>
            <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="delete_category('.$row['cat_id'].')">Delete</button></td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No categories present!</div></td></tr>';
    }
    return $show;
}
function show_edit_category($conn)
{
    $show = '';
    $cat_id = mysqli_real_escape_string($conn,$_REQUEST['cat_id']);
    $sql = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` = '$cat_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '
        <form class="row g-3 needs-validation job-form" novalidate method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <label for="input5" class="form-label">Firma</label>
                                    <input type="text" class="form-control" name="category"  id="input5" value="'.$row['category'].'">
                                </div>
                                <div class="col-12">
                                    <label for="input7" class="form-label">Beschreibung</label>
                                    <textarea name="desc"  id="input7" rows="5" class="form-control editor2"></textarea>
                                </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="edit_category">Update</button>
                            </div>
                        </form>';
                        $editor = '<script>editor2.data.set("'.$row['desc'].'");</script>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="notification error closeable">Category not present!</div>';
    }
    return array($show,$editor);
}

function edit_category($conn)
{
  $info1 = "";
  $cat_id = $_REQUEST['cat_id'];

  $category = mysqli_real_escape_string($conn,$_REQUEST['category']);
  $desc = mysqli_real_escape_string($conn,$_REQUEST['desc']);

  $sql = "UPDATE `category` SET `category` = '$category', `desc` = '$desc' WHERE `cat_id` = '$cat_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Category Updated Successfully!</div>';
    header('refresh:3');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}

function add_arbeit($conn)
{
    $arbeit = mysqli_real_escape_string($conn,$_REQUEST['arbeit']);


    $sql = query_check($conn,"INSERT INTO `arbeit` (`arbeitszeit`) VALUES ('$arbeit')");
    if($sql){
        $info = '<div class="notification success closeable">Arbeitszeit Added Successfully!</div>';
        header("Refresh:2; url=add_arbeitszeit.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}

function ad_show_arbeit($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<tr>
            <td>'.$row['arb_id'].'</td>
            <td>'.$row['arbeitszeit'].'</td>
            <td class="text-center">
                <select class="form-control" onchange="location = this.value;">
                    <option selected disabled>Select an action</option>
                    <option value="edit_arbeitszeit.php?arb_id='.$row['arb_id'].'" >Edit</option>
                    <option value="arbeitszeit.php?duplicate='.$row['arb_id'].'" >Duplicate</option>
                </select>
            </td>
            <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="delete_arbeit('.$row['arb_id'].')">Delete</button></td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No arbeitszeit present!</div></td></tr>';
    }
    return $show;
}
function show_edit_arbeit($conn)
{
    $show = '';
    $arb_id = mysqli_real_escape_string($conn,$_REQUEST['arb_id']);
    $sql = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '
        <form class="row g-3 needs-validation job-form" novalidate method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <label for="input5" class="form-label">Arbeitszeit</label>
                                    <input type="text" class="form-control" name="arbeit"  id="input5" value="'.$row['arbeitszeit'].'">
                                </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="edit_arbeit">Update</button>
                            </div>
                        </form>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="notification error closeable">arbeit not present!</div>';
    }
    return array($show);
}

function edit_arbeit($conn)
{
  $info1 = "";
  $arb_id = $_REQUEST['arb_id'];

  $arbeit = mysqli_real_escape_string($conn,$_REQUEST['arbeit']);

  $sql = "UPDATE `arbeit` SET `arbeitszeit` = '$arbeit' WHERE `arb_id` = '$arb_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Arbeit Updated Successfully!</div>';
    header('refresh:3');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}


function duplicate_arbeit($conn)
{
    $arb_id = mysqli_real_escape_string($conn,$_REQUEST['duplicate']);

    $sql = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` = '$arb_id'");
    $row = mysqli_fetch_assoc($sql);
    if(!empty($row)){
        $arbeitszeit = $row['arbeitszeit'];

        $sql = query_check($conn,"INSERT INTO `arbeit` (`arbeitszeit`)
        VALUES ('$arbeitszeit')");
        $info = '<div class="notification success closeable">Arbeitszeit Duplicated Successfully!</div>';
        header("Refresh:2; url=arbeitszeit.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}
function dlt_arbeit($conn)
{
    $show = '';
    $dlt_id = mysqli_real_escape_string($conn,$_REQUEST['dlt_id']);

    $sql = query_check($conn,"DELETE FROM `arbeit` WHERE `arb_id` = '$dlt_id'");
    if ($sql) {
        $sql1 = query_check($conn,"DELETE FROM `job_arb` WHERE `arb_id` = '$dlt_id'");
        $show = '<div class="notification success closeable">Arbeitszeit deleted successfully!</div>';
        header('refresh:3,url=arbeitszeit.php');
    } else {
        $show = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $show;
}



function add_arbeitsort($conn)
{
    $arbeitsort = mysqli_real_escape_string($conn,$_REQUEST['arbeitsort']);


    $sql = query_check($conn,"INSERT INTO `arbeitsort` (`arbeitsort`) VALUES ('$arbeitsort')");
    if($sql){
        $info = '<div class="notification success closeable">Arbeitsort Added Successfully!</div>';
        header("Refresh:2; url=add_arbeitsort.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}

function ad_show_arbeitsort($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<tr>
            <td>'.$row['sort_id'].'</td>
            <td>'.$row['arbeitsort'].'</td>
            <td class="text-center">
                <select class="form-control" onchange="location = this.value;">
                    <option selected disabled>Select an action</option>
                    <option value="edit_arbeitsort.php?sort_id='.$row['sort_id'].'" >Edit</option>
                    <option value="arbeitsort.php?duplicate='.$row['sort_id'].'" >Duplicate</option>
                </select>
            </td>
            <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="delete_arbeitsort('.$row['sort_id'].')">Delete</button></td>
        </tr>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<tr><td colspan="7"><div class="notification error closeable">No arbeitsort present!</div></td></tr>';
    }
    return $show;
}

function show_edit_arbeitsort($conn)
{
    $show = '';
    $sort_id = mysqli_real_escape_string($conn,$_REQUEST['sort_id']);
    $sql = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '
        <form class="row g-3 needs-validation job-form" novalidate method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <label for="input5" class="form-label">Arbeitsort</label>
                                    <input type="text" class="form-control" name="arbeitsort"  id="input5" value="'.$row['arbeitsort'].'">
                                </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="edit_arbeitsort">Update</button>
                            </div>
                        </form>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="notification error closeable">Arbeit not present!</div>';
    }
    return array($show);
}

function edit_arbeitsort($conn)
{
  $info1 = "";
  $sort_id = $_REQUEST['sort_id'];

  $arbeitsort = mysqli_real_escape_string($conn,$_REQUEST['arbeitsort']);

  $sql = "UPDATE `arbeitsort` SET `arbeitsort` = '$arbeitsort' WHERE `sort_id` = '$sort_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Arbeitsort Updated Successfully!</div>';
    header('refresh:3');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}


function duplicate_arbeitsort($conn)
{
    $sort_id = mysqli_real_escape_string($conn,$_REQUEST['duplicate']);

    $sql = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` = '$sort_id'");
    $row = mysqli_fetch_assoc($sql);
    if(!empty($row)){
        $arbeitsort = $row['arbeitsort'];

        $sql = query_check($conn,"INSERT INTO `arbeitsort` (`arbeitsort`)
        VALUES ('$arbeitsort')");
        $info = '<div class="notification success closeable">Arbeitsort Duplicated Successfully!</div>';
        header("Refresh:2; url=arbeitsort.php");
    }else {
        $info = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $info;
}
function dlt_arbeitsort($conn)
{
    $show = '';
    $dlt_id = mysqli_real_escape_string($conn,$_REQUEST['dlt_id']);

    $sql = query_check($conn,"DELETE FROM `arbeitsort` WHERE `sort_id` = '$dlt_id'");
    if ($sql) {
        $sql1 = query_check($conn,"DELETE FROM `job_sort` WHERE `sort_id` = '$dlt_id'");
        $show = '<div class="notification success closeable">Arbeitsort deleted successfully!</div>';
        header('refresh:3,url=arbeitsort.php');
    } else {
        $show = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $show;
}



function edit_job($conn)
{
  $info1 = "";
  $j_id = $_REQUEST['j_id'];

  $title = mysqli_real_escape_string($conn,$_REQUEST['title']);
  $job_desc = mysqli_real_escape_string($conn,$_REQUEST['job_desc']);
  $date = date('Y-m-d', strtotime($_REQUEST['date']));
  $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
  $app_link = mysqli_real_escape_string($conn,$_REQUEST['app_link']);
  $application = mysqli_real_escape_string($conn,$_REQUEST['application']);
  $c_id = mysqli_real_escape_string($conn,$_REQUEST['c_id']);
  $start = mysqli_real_escape_string($conn,$_REQUEST['start']);
  $contact_person = mysqli_real_escape_string($conn,$_REQUEST['contact_person']);
  $telephone = mysqli_real_escape_string($conn,$_REQUEST['telephone']);
  $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
  $aufgabe = mysqli_real_escape_string($conn,$_REQUEST['aufgabe']);
  $anforderungen = mysqli_real_escape_string($conn,$_REQUEST['anforderungen']);
  $benefits = mysqli_real_escape_string($conn,$_REQUEST['benefits']);

  $sql = "UPDATE `jobs` SET `title` = '$title', `job_desc` = '$job_desc', `end_date`= '$end_date',
   `date`= '$date', `app_link`  = '$app_link', `application` = '$application', `c_id` = '$c_id', 
   `start` = '$start', `contact_person` = '$contact_person', `telephone` = '$telephone', `email` = '$email',
    `aufgabe` = '$aufgabe', `anforderungen` = '$anforderungen', `benefits` = '$benefits' WHERE `j_id` = '$j_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    if (isset($_REQUEST['cat_id'])) {
        $category = $_REQUEST['cat_id'];
        $sql1 = query_check($conn, "DELETE FROM `job_cat` WHERE `j_id` = '$j_id'");
        foreach ($category as $cat_id) {
            $sql2 = query_check($conn,"INSERT INTO `job_cat` (`j_id`,`cat_id`) VALUES ('$j_id','$cat_id')");
        }
    }

    if (isset($_REQUEST['arb_id'])) {
        $arbeitszeit = $_REQUEST['arb_id'];
        $sql1 = query_check($conn, "DELETE FROM `job_arb` WHERE `j_id` = '$j_id'");
        foreach ($arbeitszeit as $arb_id) {
            $sql2 = query_check($conn,"INSERT INTO `job_arb` (`j_id`,`arb_id`) VALUES ('$j_id','$arb_id')");
        }
    }

    if (isset($_REQUEST['sort_id'])) {
        $arbeitsort = $_REQUEST['sort_id'];
        $sql1 = query_check($conn, "DELETE FROM `job_sort` WHERE `j_id` = '$j_id'");
        foreach ($arbeitsort as $sort_id) {
            $sql2 = query_check($conn,"INSERT INTO `job_sort` (`j_id`,`sort_id`) VALUES ('$j_id','$sort_id')");
        }
    }
    $info1 = '<div class="notification success closeable" role="alert">Job Updated Successfully!</div>';
    header('refresh:3');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}



function edit_company($conn)
{
  $info1 = "";
  $c_id = $_REQUEST['c_id'];

  $company = mysqli_real_escape_string($conn,$_REQUEST['company']);
  $desc = mysqli_real_escape_string($conn,$_REQUEST['desc']);
  $place = mysqli_real_escape_string($conn,$_REQUEST['place']);
  $name = mysqli_real_escape_string($conn,$_REQUEST['name']);
  $apply = mysqli_real_escape_string($conn,$_REQUEST['apply']);
  $phone = mysqli_real_escape_string($conn,$_REQUEST['phone']);
  $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
  $website = mysqli_real_escape_string($conn,$_REQUEST['website']);
  $instagram = mysqli_real_escape_string($conn,$_REQUEST['instagram']);
  $facebook = mysqli_real_escape_string($conn,$_REQUEST['facebook']);
  $youtube = mysqli_real_escape_string($conn,$_REQUEST['youtube']);
  if(!empty($_FILES['c_logo']['name'])){

    $target_dir = 'logos/';
    $temp = $_FILES['c_logo']['tmp_name'];
    $uniq = time().rand(1000,9999);
    $info = pathinfo($_FILES['c_logo']['name']);

    $target_file = $target_dir . basename($_FILES["c_logo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //    Allow certain files formats
    if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png" ) {
        $info = '<div class="notification error closeable"  role="alert">Sorry only JPF,JPEG and PNG formats are allowed!</div>';
        return $info;
        die();
    }

    //  Check image size
    $size = $_FILES["c_logo"]["size"];
    if ($size > 5000000) {
    $info ='<div class="notification error closeable" role="alert">Sorry! logo cannot be larger than 5MB</div>';
    return $info;
        die();
    }
    $image_name = "c_logo_".$uniq.".".$info['extension']; //with your created name
    if(file_exists($target_dir.$image_name)){

        while(file_exists($target_dir)) {
    $temp = $_FILES['c_logo']['tmp_name'];
    $uniq = time().rand(1000,9999);
    $info = pathinfo($_FILES['c_logo']['name']);
    $image_name = "c_logo_".$uniq.".".$info['extension']; //with your created name
        }

    move_uploaded_file($temp, $target_dir.$image_name);
    }

    move_uploaded_file($temp, $target_dir.$image_name);
    $attach = ", `c_logo` = '{$image_name}'";
}else{
    $attach = "";
}
  $sql = "UPDATE `company` SET  `company` = '$company',
   `desc` = '$desc', `place` = '$place', `name` = '$name', `apply` = '$apply', `phone` = '$phone',
   `email` = '$email', `website` = '$website', `instagram` = '$instagram', `facebook` = '$facebook', `youtube` = '$youtube'".$attach." WHERE `c_id` = '$c_id'";
  $check = mysqli_query($conn, $sql);
  if ($check) {
    $info1 = '<div class="notification success closeable" role="alert">Company Updated Successfully!</div>';
    header('refresh:3');
  } else {
    $info1 = '<div class="notification error closeable" role="alert">An error occurred!</div>';
  }

  return $info1;
}


function dlt_company($conn)
{
    $show = '';
    $dlt_id = mysqli_real_escape_string($conn,$_REQUEST['dlt_id']);

    $sql = query_check($conn,"DELETE FROM `jobs` WHERE `c_id` = '$dlt_id'");
    $sql1 = query_check($conn,"DELETE FROM `company` WHERE `c_id` = '$dlt_id'");
    if ($sql1) {
        $show = '<div class="notification success closeable">Company deleted successfully!</div>';
        header('refresh:3,url=company.php');
    } else {
        $show = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $show;
}

function dlt_cat($conn)
{
    $show = '';
    $dlt_id = mysqli_real_escape_string($conn,$_REQUEST['dlt_id']);

    $sql = query_check($conn,"DELETE FROM `category` WHERE `cat_id` = '$dlt_id'");
    if ($sql) {
        $sql1 = query_check($conn,"DELETE FROM `job_cat` WHERE `cat_id` = '$dlt_id'");
        $show = '<div class="notification success closeable">Category deleted successfully!</div>';
        header('refresh:3,url=category.php');
    } else {
        $show = '<div class="notification error closeable">An error occurred, try again!</div>';
    }
    return $show;
}


function show_company_list($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `company` WHERE `c_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<option value="'.$row['c_id'].'">'.$row['c_id'].' - '.$row['company'].'</option>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<option value="" disabled>No Company Present</option>';
    }
    return $show;
}
function show_category_list($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    $i = 1;
    if (!empty($row)) {
        do {
            $checked = '';
            if (isset($_REQUEST['cat_id'])) {
                $cat_id = $row['cat_id'];
                $cat_ids = $_REQUEST['cat_id'];
                if (in_array($cat_id, $cat_ids)) {
                    $checked = ' checked';
                }else{
                    $checked = '';
                }
            }
            $show .= '<div class="form-check">
            <input class="form-check-input" type="checkbox" id="c_check'.$i.'" name="cat_id[]" value="'.$row['cat_id'].'" '.$checked.'>
            <label class="form-check-label" for="c_check'.$i.'">
                '.$row['category'].'
            </label>
        </div>';
        $i++;
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="form-check">
        <input class="form-check-input" type="checkbox" id="c_check'.$i.'" name="cat_id[]" value="" disabled>
        <label class="form-check-label" for="c_check'.$i.'">
            No Category Present
        </label>
    </div>';
    }
    return $show;
}

function show_arbeitszeit_list($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    $i = 1;

    $checked = '';
    if (!empty($row)) {
        do {
            $checked = '';
            if (isset($_REQUEST['arb_id'])) {
                $arb_id = $row['arb_id'];
                $arb_ids = $_REQUEST['arb_id'];
                if (in_array($arb_id, $arb_ids)) {
                    $checked = ' checked';
                }else{
                    $checked = '';
                }
            }
            $show .= '<div class="form-check">
            <input class="form-check-input" type="checkbox" id="a_check'.$i.'" name="arb_id[]" value="'.$row['arb_id'].'"  '.$checked.'>
            <label class="form-check-label" for="a_check'.$i.'">
                '.$row['arbeitszeit'].'
            </label>
        </div>';
        $i++;
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="form-check">
        <input class="form-check-input" type="checkbox" id="a_check'.$i.'" name="cat_id[]" value="" disabled>
        <label class="form-check-label" for="a_check'.$i.'">
            No Arbeitszeit Present
        </label>
    </div>';
    }
    return $show;
}
function show_arbeitsort_list($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    $i = 1;
    if (!empty($row)) {
        do {
            $checked = '';
            if (isset($_REQUEST['sort_id'])) {
                $sort_id = $row['sort_id'];
                $sort_ids = $_REQUEST['sort_id'];
                if (in_array($sort_id, $sort_ids)) {
                    $checked = ' checked';
                }else{
                    $checked = '';
                }
            }
            $show .= '<div class="form-check">
            <input class="form-check-input" type="checkbox" name="sort_id[]" value="'.$row['sort_id'].'"  '.$checked.'>
            <label class="form-check-label" for="s_check'.$i.'">
                '.$row['arbeitsort'].'
            </label>
        </div>';
        $i++;
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="form-check">
        <input class="form-check-input" type="checkbox" name="cat_id[]" value="" disabled>
        <label class="form-check-label" for="s_check'.$i.'">
            No arbeitsort Present
        </label>
    </div>';
    }
    return $show;
}



function show_category_list2($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    $i = 1;
    if (!empty($row)) {
        do {
            $selected = '';
            if (isset($_REQUEST['cat_id'])) {
                $cat_id = $row['cat_id'];
                $cat_ids = $_REQUEST['cat_id'];
                if (in_array($cat_id, $cat_ids)) {
                    $selected = ' selected';
                }else{
                    $selected = '';
                }
            }
            $show .= '<option value="'.$row['cat_id'].'" '.$selected.'>'.$row['category'].'</option>';
        $i++;
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<option value="" selected disabled>No categories present</option>';
    }
    return $show;
}

function show_arbeitszeit_list2($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    $i = 1;

    $checked = '';
    if (!empty($row)) {
        do {
            $checked = '';
            if (isset($_REQUEST['arb_id'])) {
                $arb_id = $row['arb_id'];
                $arb_ids = $_REQUEST['arb_id'];
                if (in_array($arb_id, $arb_ids)) {
                    $checked = ' checked';
                }else{
                    $checked = '';
                }
            }
            $show .= '<div class="switch-container">
            <label class="switch"><input type="checkbox" name="arb_id[]" '.$checked.' value="'.$row['arb_id'].'"><span class="switch-button"></span> '.$row['arbeitszeit'].'</label>
        </div>';
        $i++;
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<div class="switch-container">
        <label class="switch"><input type="checkbox" name="arb_id[]" value="" disabled><span class="switch-button"></span> No arbeitszeit present</label>
    </div>';
    }
    return $show;
}
function show_arbeitsort_list2($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    $i = 1;
    if (!empty($row)) {
        do {
            $selected = '';
            if (isset($_REQUEST['sort_id'])) {
                $sort_id = $row['sort_id'];
                $sort_ids = $_REQUEST['sort_id'];
                if (in_array($sort_id, $sort_ids)) {
                    $selected = ' selected';
                }else{
                    $selected = '';
                }
            }
            $show .= '<option value="'.$row['sort_id'].'" '.$selected.'>'.$row['arbeitsort'].'</option>';
        $i++;
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<option value="" selected disabled>No arbeitsort present</option>';
    }
    return $show;
}



function category_links($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `category` WHERE `cat_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<li><a class="dropdown-item" href="category_details.php?cat_id1='.$row['cat_id'].'">'.$row['category'].'</a></li>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<li><a class="dropdown-item disabled">No Category</a></li>';
    }
    return $show;
}

function arbeitsort_links($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeitsort` WHERE `sort_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<li><a class="dropdown-item" href="arbeitsort_details.php?sort_id1='.$row['sort_id'].'">'.$row['arbeitsort'].'</a></li>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<li><a class="dropdown-item disabled">No arbeitsort</a></li>';
    }
    return $show;
}

function place_links($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `jobs` WHERE `j_id` > 0 AND `arbeitsort` != '' GROUP BY `arbeitsort`");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<li><a class="dropdown-item" href="place_details.php?place='.$row['arbeitsort'].'">'.$row['arbeitsort'].'</a></li>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<li><a class="dropdown-item disabled">No place</a></li>';
    }
    return $show;
}


function arbeitszeit_links($conn)
{
    $show = '';
    $sql = query_check($conn,"SELECT * FROM `arbeit` WHERE `arb_id` > 0");
    $row = mysqli_fetch_assoc($sql);
    if (!empty($row)) {
        do {
            $show .= '<li><a class="dropdown-item" href="arbeitszeit_details.php?arb_id1='.$row['arb_id'].'">'.$row['arbeitszeit'].'</a></li>';
        } while ($row = mysqli_fetch_assoc($sql));
    } else {
        $show = '<li><a class="dropdown-item disabled">No arbeitszeit</a></li>';
    }
    return $show;
}
?>
