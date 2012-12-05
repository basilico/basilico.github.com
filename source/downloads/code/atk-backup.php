<?php

// includes
$config_atkroot = "./";
include_once("atk.inc");
atksession();
atksecure();

// Utility
function format($s) {
  return str_replace("_"," - ",$s);
}


// Defaults
if(STATUS == 'sviluppo') {
  $mysql_bin = "/Applications/MAMP/Library/bin/";
  $backup_dir = "backups/";
}
if(STATUS == 'online') {
  $mysql_bin = "/usr/bin/";
  $backup_dir = "backups/";
}

// Elimino
if(isset($ATK_VARS['backup_del']) && !empty($ATK_VARS['backup_del'])) {
  $backup = $backup_dir . $ATK_VARS['backup_file'] . ".sql";
  if(file_exists($backup)) {
    @unlink($backup);
  }
}

// 
if(isset($ATK_VARS['backup'])) {
  $u_date = date("Y.m.d_H.i.s");
  system("{$mysql_bin}mysqldump {$config_db["default"]["db"]} > {$backup_dir}backup_{$u_date}.sql --opt -h {$config_db["default"]["host"]} -u {$config_db["default"]["user"]}  --password={$config_db["default"]["password"]}", $res);
}


// Status dei salvataggi durante la sessione
if(!isset($res)) {
  $o_status = '<font color="gray"><strong>NON ESEGUITO</strong></font>';
}elseif($res==0) {
  $o_status = '<font color="green"><strong>ESEGUITO</strong></font>';
} elseif($res>0) {
  $o_status = '<font color="red"><strong>ERRORE</strong></font>';
}

// Creo elenco delle cartelle già presenti
foreach (glob("{$backup_dir}*.sql") as $x_folder) {
  $x_folder = basename($x_folder,".sql");
  $x_folder_view = format($x_folder);
  $o_options.= "<option value=\"$x_folder\">$x_folder_view</option>";
}


// Output Vars
$o_title = "Backup gestionale";
$o_content = <<< HTML
<br><br>
<p>Esito del backup: $o_status</p>
<br><br>
<p>
  <button onclick="location.href='backup.php?backup';this.disabled=true;">Esegui backup</button>
</p>
<hr>
<br><br>
<p><strong>Manutenzione</strong></p>
<form>
<p>
  Elimina backup:
  <select name="backup_file" onchange="document.getElementById('backup_del').disabled=false;">
    <option>Scegli backup...</option>
    $o_options
  </select>
  <input type="submit" disabled name="backup_del" id="backup_del" value="Elimina backup" />
</p>
</form>
HTML;

// page class setup
$indexpage = &atknew('atk.ui.atkindexpage');
$indexpage->atkGenerateTop();
$indexpage->atkGenerateMenu();
$box = $indexpage->m_ui->renderBox(array("title"=>$o_title, "content"=>$o_content));
$indexpage->m_page->addContent($box);
$indexpage->m_output->output($indexpage->m_page->render("$o_title"));
$indexpage->m_output->outputFlush();
