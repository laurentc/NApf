<?php
$methods = "";
$properties = "";
$primary = $this->_primary;
$methods .= "\tpublic function __construct(\$id = null){\n";
$methods .= "\t\t\$this->_dao = new \\$class(\"$this->_table\"," . var_export($this->_connection,true) . ");\n";
$methods .= "\t\t\$this->preLoad();\n";
$methods .= "\t\tif(\$id !== null){\n";
$methods .= "\t\t\t\$values = \$this->_dao->get(\$id);\n";
$methods .= "\t\t\tforeach(\$values as \$key=>\$val){\n";
$methods .= "\t\t\t\t\$private = \"_\$key\";\n";
$methods .= "\t\t\t\t\$this->\$private = \$val;\n";
$methods .= "\t\t\t}\n";
$methods .= "\t\t}\n";
$methods .= "\t\t\$this->postLoad();\n";
$methods .= "\t}\n";
$datas = "array(";
$first = true;
foreach($this->_fields as $key=>$val){
    $properties .= "\tprivate \$_" . $key .";\n";

    $methods .= "\tpublic function get" . ucfirst($key) . "(){\n";
    $methods .= "\t\treturn \$this->_" . $key .";\n";
    $methods .= "\t}\n";
    $methods .= "\tpublic function set" . ucfirst($key) . "(\$val){\n";
    $methods .= "\t\t\$this->_" . $key ." = \$val;\n";
    $methods .= "\t}\n";
    if($val["key"] !== "PRI"){
        if(!$first){
            $datas .= ", ";
        }
        $datas .= '"' . $key . '"=>$this->_' . $key;
        $first = false;
    }
}
$datas .= ")";
$methods .= "\tpublic function preSave(){\n";
$methods .= "\t\t\n";
$methods .= "\t}\n";
$methods .= "\tpublic function postSave(){\n";
$methods .= "\t\t\n";
$methods .= "\t}\n";
$methods .= "\tpublic function preLoad(){\n";
$methods .= "\t\t\n";
$methods .= "\t}\n";
$methods .= "\tpublic function postLoad(){\n";
$methods .= "\t\t\n";
$methods .= "\t}\n";
$methods .= "\tpublic function save(){\n";
$methods .= "\t\t\$this->preSave();\n";
$methods .= "\t\t\$datas = $datas;\n";
$methods .= "\t\tif(!empty(\$this->_$primary)){\n";
$methods .= "\t\t\t\$this->_dao->update(\$this->_$primary, \$datas);\n";
$methods .= "\t\t}else{\n";
$methods .= "\t\t\t\$this->_$primary = \$this->_dao->insert(\$datas);\n";
$methods .= "\t\t}\n";
$methods .= "\t\t\$this->postSave();\n";
$methods .= "\t}\n";
$methods .= "\tpublic function delete(){\n";
$methods .= "\t\t\$this->_dao->delete(\$this->_$primary);\n";
$methods .= "\t\t\$this->_$primary = null;\n";
$methods .= "\t}\n";


$output = "<?php\n";
$output .= "namespace beans;\n";
$output .= "\n";
$output .= "class " . ucfirst($this->_table) . "Bean extends \\napf\\dao\\AbstractBean\n";
$output .= "\n";
$output .= "{\n";
$output .= $properties;
$output .= "\n";
$output .= $methods;
$output .= "}";

