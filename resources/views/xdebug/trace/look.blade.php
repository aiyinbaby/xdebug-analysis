<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <style>
        table{
            width: 100%;
            margin-bottom: 50px;
        }

        td{
            max-width: 25%;
            max-height: 200px;
        }

        tr{
            max-height: 200px;
        }
    </style>
</head>
<body>

    <table style="" border="1">
        <tr>
            <td colspan="/" style="">
                <a href="/xdebug/trace/look?id={{@$nodeData['id']}}&parentStack={{implode(',',$nodeData['parentStack'])}}">
                    current_function
                </a>
            </td>
        </tr>
        <tr>
            <td>level</td>
            <td>id</td>
            <td>func_name</td>
            <td>param</td>
            <td>return value</td>
            <td>file_name</td>
            <td>line_no</td>
        </tr>
        <tr>
            <td>{{@$nodeData['level']}}</td>
            <td>{{@$nodeData['id']}}</td>
            <td>{{@$nodeData['func_name']}}</td>
            <td>{{@ddl($nodeData['JParam'])}}</td>
            <td>{{@ddl($nodeData['JRet'])}}</td>
            <td>{{@$nodeData['file_name']}}</td>
            <td>{{@$nodeData['line_no']}}</td>
        </tr>
    </table>

    <table style="" border="1">
        <tr>
            <td colspan="7"  style="">
                <a href="/xdebug/trace/look?id={{@$parentData['id']}}&parentStack={{@implode(',',$parentData['parentStack'])}}">
                    parent_function
                </a>
            </td>
        </tr>

        <tr>
            <td>level</td>
            <td>id</td>
            <td>func_name</td>
            <td>param</td>
            <td>return value</td>
            <td>file_name</td>
            <td>line_no</td>
        </tr>

        <tr>
            <td>{{@$nodeData['level']}}</td>
            <td>{{@$nodeData['id']}}</td>
            <td>{{@$nodeData['func_name']}}</td>
            <td>{{@ddl($nodeData['JParam'])}}</td>
            <td>{{@ddl($nodeData['JRet'])}}</td>
            <td>{{@$nodeData['file_name']}}</td>
            <td>{{@$nodeData['line_no']}}</td>
        </tr>
    </table>

    <table style="" border="1">
        <tr>
            <td colspan="7"  style="">
                child_function
            </td>
        </tr>

        <tr>
            <td>level</td>
            <td>id</td>
            <td>func_name</td>
            <td>param</td>
            <td>return value</td>
            <td>file_name</td>
            <td>line_no</td>
        </tr>

        @foreach($childData as $child)
            <tr>
                <td>{{@$child['level']}}</td>
                <td>{{@$child['id']}}</td>
                <td>
                    <a href="/xdebug/trace/look?id={{@$child['id']}}&parentStack={{@implode(',',$child['parentStack'])}}"
                        @if(!empty($child['cid']))
                           style=""
                        @endif
                    >
                        {{@$child['func_name']}}
                    </a>
                </td>
                <td>{{@ddl($child['JParam'])}}</td>
                <td>{{@ddl($child['JRet'])}}</td>
                <td>{{@$child['file_name']}}</td>
                <td>{{@$child['line_no']}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>