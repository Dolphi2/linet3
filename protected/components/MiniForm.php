<?php
class MiniForm extends CWidget
{
 
    public $name = ' ';
    public $width = '';
    public $height = '';
    public $logo = '';
    public $help = '';
    public $haeder= '';
    public $back= '';
    public $text= '';
    public $titlewidth=0;
    
    public function init()
    {
    	ob_start();
        parent::init();
 
        // Site Name
        if ($this->name == ' ')  {
            $this->name = '';
        }
 
        if(($this->logo!='')&&(file_exists($this->logo)))$this->logo="<img src=\"$this->logo\" alt=\"$this->logo\" />";else $logo="<img src=\"images/icon.png\" alt=\"images/icon.png\" />";
		if(isset($back)){
			$l=_("Back");
			$back='<div class="formback"><a href="javascript:history.go(-1)">'.$l.'&nbsp;<img src="images/icon_back.png" alt="Icon back" /></a></div>';
			$this->titlewidth=75;
		}else 	
			$back='';
		if ($this->help!=''){
			$l=_("Help");
			$this->help='<div class="formhelp"><a class="help" target="_blank" href="'.$this->help.'"><img src="images/icon_help.png" alt="Icon help" /><span>'.$l.'</span></a></div>';
			$this->titlewidth+=75;
		}else{
			$this->help='';
		}
		
 
        
    }
 
    /**
     * Display the widget
     * @see CWidget::run()
     */
    public function run(){//style="width:'.($this->width-$this->titlewidth-28).'px;"
    	$content = ob_get_clean();
		$newform='
		<table id="resizable" class="form '.$this->name.'">
			<tr>
				<td class="ftr"><img src="images/ftr.png" alt="formright"  /></td>
				<td class="ftc"><div class="formtitle"  >'.$this->logo.'<span>'.$this->haeder.'</span></div>'.$this->back.$this->help.'</td>
				<td class="ftl"><img src="images/ftl.png" alt="formleft" /></td>
			</tr>
			<tr>
				<td class="fcr"></td>
				<td class="fcc" style="height:'.($this->height-140).'px;">
					'.$content.'
				</td>
				<td class="fcl"></td>
			</tr>
			<tr>
			<td class="fbr"><img src="images/fbr.png" alt="formright" /></td>
			<td class="fbc"></td>
			<td class="fbl"><img src="images/fbl.png" alt="formleft" /></td>
			</tr>
		</table>
		
		
		';
	
		echo $newform;
    }
}