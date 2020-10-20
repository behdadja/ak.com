
<h2>معلم</h2>
<ul>
    <?php
    //var_dump($class_info);
    if (isset($class_info['attendee']['role'])){
        if ($class_info['attendee']['role'] == 'MODERATOR'){
            ?><li> <?php echo $class_info['attendee']['fullName']; ?></li><?php
        }
    } elseif(isset($class_info['attendee'][0]->role)){
        for ($i = 0 ; $i < count($class_info['attendee']); $i++){
            if ($class_info['attendee'][$i]->role == "MODERATOR"){
                ?><li> <?php echo $class_info['attendee'][$i]->fullName; ?></li><?php
            }
        }
    }
    ?>
</ul>

<h2>دانش آموز</h2>
<ol>
    <?php
    if (isset($class_info['attendee']['role'])){
        if ($class_info['attendee']['role'] == 'VIEWER'){
            ?><li> <?php echo $class_info['attendee']['fullName']; ?></li><?php
        }

    } elseif(isset($class_info['attendee'][0]->role)){
        for ($i = 0 ; $i < count($class_info['attendee']); $i++){
            if ($class_info['attendee'][$i]->role == "VIEWER"){
                ?><li> <?php echo $class_info['attendee'][$i]->fullName; ?></li><?php
            }
        }
    }
    ?>
</ol>
