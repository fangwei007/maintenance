/*
	*	Original script by: Shafiul Azam
	*	ishafiul@gmail.com
	*	Version 3.0
	*	Modified by: Luigi Balzano

	*	Description:
	*	Inserts Countries and/or States as Dropdown List
	*	How to Use:

		In Head section:
		<script type= "text/javascript" src = "countries.js"></script>
		In Body Section:
		Select Country:   <select onchange="print_state('state',this.selectedIndex);" id="country" name ="country"></select>
		<br />
		City/District/State: <select name ="state" id ="state"></select>
		<script language="javascript">print_country("country");</script>	

	*
	*	License: OpenSource, Permission for modificatin Granted, KEEP AUTHOR INFORMATION INTACT
	*	Aurthor's Website: http://shafiul.progmaatic.com
	*
*/
var country_arr = {};
country_arr = new Array("美国", "中国");
var country_code_arr = new Array("US", "CN");

var select_country = {};
select_country = "选择国家";

var select_state = {};
select_state = "选择州或省";

var s_a = {};
s_a[0]="";
s_a[1]="Alabama|AL|Alaska|AK|Arizona|AZ|Arkansas|AR|California|CA|Colorado|CO|Connecticut|CT|Delaware|DE|District of Columbia|DC|Florida|FL|Georgia|GA|Hawaii|HI|Idaho|ID|Illinois|IL|Indiana|IN|Iowa|IA|Kansas|KS|Kentucky|KY|Louisiana|LA|Maine|ME|Maryland|MD|Massachusetts|MA|Michigan|MI|Minnesota|MN|Mississippi|MS|Missouri|MO|Montana|MT|Nebraska|NE|Nevada|NV|New Hampshire|NH|New Jersey|NJ|New Mexico|NM|New York|NY|North Carolina|NC|North Dakota|ND|Ohio|OH|Oklahoma|OK|Oregon|OR|Pennsylvania|PA|Rhode Island|RI|South Carolina|SC|South Dakota|SD|Tennessee|TN|Texas|TX|Utah|UT|Vermont|VT|Virginia|VA|Washington|WA|West Virginia|WV|Wisconsin|WI|Wyoming|WY";
s_a[2]="安徽|AH|北京|BJ|重庆|CQ|福建|FJ|甘肃|GS|广东|GD|广西|GX|贵州|GZ|海南|HI|河北|HB|黑龙江|HL|河南|HA|湖北|HB|湖南|HN|江苏|JS|江西|JX|吉林|JL|辽宁|LN|内蒙古|NM|宁夏|NX|青海|QH|陕西|SN|山东|SD|上海|SH|山西|SX|四川|SC|天津|TJ|新疆|XJ|西藏|XZ|云南|YN|浙江|ZJ";


function print_country(country_id, seleted_country_code){
	// given the id of the <select> tag as function argument, it inserts <option> tags
        
	var option_str = document.getElementById(country_id);
	option_str.length=0;
	option_str.options[0] = new Option(select_country,'');
	option_str.selectedIndex = 0;
	for (var i=0; i<country_arr.length; i++) {
		option_str.options[option_str.length] = new Option(country_arr[i],country_code_arr[i]);
                if(country_code_arr[i] === seleted_country_code){
                    option_str.selectedIndex = i+1;
                }
	}
}

function print_state(state_id, state_index, seleted_state_code){
	var option_str = document.getElementById(state_id);
	option_str.length=0;	// Fixed by Julian Woods
	option_str.options[0] = new Option(select_state,'');
	option_str.selectedIndex = 0;
	var state_arr = s_a[state_index].split("|");
        var state_name_arr = new Array();
        var state_code_arr = new Array();
        for (var i=0; i<state_arr.length; i+=2) {
		state_name_arr.push(state_arr[i]);
		state_code_arr.push(state_arr[i+1]);
        }
	for (var i=0; i<state_name_arr.length; i++) {
		option_str.options[option_str.length] = new Option(state_name_arr[i],state_code_arr[i]);
                if(state_code_arr[i] === seleted_state_code){
                    option_str.selectedIndex = i+1;
                }
	}
}