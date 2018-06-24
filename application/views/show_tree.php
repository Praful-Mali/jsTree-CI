<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>JS Tree View</title>
	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
</head>
<body>
<div class="row">

    <div class="container">


        <input type="hidden" name="node" id="node" value="" />

        <div class="form-group">
            <div id="tree-container"></div>
            </div>
        </div>
    </div>

	<script type="text/javascript">
            $(document).ready(function(){

                //setting to hidden field
                //fill data to tree  with AJAX call
                $('#tree-container').on('changed.jstree', function (e, data) {
                    var i, j, r = [];
                    // var state = false;
                    for(i = 0, j = data.selected.length; i < j; i++) {
                        r.push(data.instance.get_node(data.selected[i]).id);
                    }
                    $('#txttuser').val(r.join(','));
                }).jstree({
                            'plugins': ["wholerow","checkbox"],
                            'core' : {
                                "multiple" : true,
                                'data' : {
                                    "url" : "items/getChildren",
                                    "dataType" : "json" // needed only if you do not supply JSON headers
                                }
                            },
                            'checkbox': {
                                three_state: false,
                                cascade: 'up'
                            },
                            'plugins': ["checkbox"]
                        }
                )
            });
</script>


</body>
</html>