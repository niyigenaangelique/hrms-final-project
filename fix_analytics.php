<?php
$file = __DIR__ . '/resources/views/livewire/analytics/analytics-dashboard.blade.php';
$content = file_get_contents($file);

// Find the last @endif and truncate there
$lastEndif = strrpos($content, '@endif');
if ($lastEndif === false) { die("@endif not found"); }
$content = substr($content, 0, $lastEndif + strlen('@endif')) . "\n";

$script = <<<'BLADE'

<script>
window.__an={hireExit:@json($hireExitTrend),turnData:@json($turnoverTrend),deptData:@json($deptData),genderData:@json($genderData),ageData:@json($ageData),skillGap:@json($skillGap),predicted:@json($predicted),nationalityData:@json($nationalityData)};
(function(){
var C={I:'#3B6FE8',V:'#6B4FDB',T:'#10B981',R:'#F43F5E',A:'#F59E0B',G:'#10B981',P:'#8B5CF6',B:'#3B82F6'};
function sd(id){var c=Chart.getChart(id);if(c)c.destroy();}
function g(id){return document.getElementById(id);}
function dHE(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.hireExit;
  new Chart(el,{type:'bar',data:{labels:d.map(function(r){return r.label;}),datasets:[
    {label:'Hires',data:d.map(function(r){return r.hires;}),backgroundColor:'rgba(59,111,232,0.75)',borderRadius:6,borderSkipped:false},
    {label:'Exits',data:d.map(function(r){return r.exits;}),backgroundColor:'rgba(244,63,94,0.65)',borderRadius:6,borderSkipped:false}
  ]},options:{responsive:true,maintainAspectRatio:false,
    plugins:{legend:{display:true,position:'top',labels:{usePointStyle:true,pointStyle:'circle',padding:16,font:{weight:'600'}}},tooltip:{mode:'index',intersect:false}},
    scales:{x:{grid:{display:false},ticks:{maxRotation:0,font:{size:11}}},y:{grid:{color:'rgba(59,111,232,0.06)'},ticks:{precision:0},beginAtZero:true}}
  }});}
function dD(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.deptData;var K=[C.I,C.V,C.T,C.A,C.G,C.R,C.P,C.B];
  new Chart(el,{type:'bar',data:{labels:d.map(function(r){return r.label;}),datasets:[{data:d.map(function(r){return r.value;}),backgroundColor:d.map(function(_,i){return K[i%K.length];}),borderRadius:6,borderSkipped:false}]},
    options:{indexAxis:'y',responsive:true,maintainAspectRatio:false,plugins:{tooltip:{callbacks:{label:function(c){return' '+c.raw+' employees';}}}},
    scales:{x:{grid:{color:'rgba(59,111,232,0.06)'},ticks:{precision:0},beginAtZero:true},y:{grid:{display:false},ticks:{font:{size:11,weight:'600'}}}}}});}
function dG(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.genderData;
  new Chart(el,{type:'doughnut',data:{labels:d.map(function(r){return r.label;}),datasets:[{data:d.map(function(r){return r.value;}),backgroundColor:[C.I,C.T,C.R],borderWidth:0,hoverOffset:6}]},
    options:{responsive:true,maintainAspectRatio:false,cutout:'68%',plugins:{tooltip:{callbacks:{label:function(c){return' '+c.label+': '+c.raw+' ('+d[c.dataIndex].percent+'%)';}}}}}});}
function dA(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.ageData;var t=d.reduce(function(s,r){return s+r.value;},0);
  new Chart(el,{type:'bar',data:{labels:d.map(function(r){return r.label;}),datasets:[{data:d.map(function(r){return r.value;}),backgroundColor:['rgba(59,111,232,0.50)','rgba(59,111,232,0.65)','rgba(59,111,232,0.85)','rgba(59,111,232,0.65)','rgba(59,111,232,0.45)'],borderRadius:6,borderSkipped:false}]},
    options:{responsive:true,maintainAspectRatio:false,plugins:{tooltip:{callbacks:{label:function(c){return' '+c.raw+' ('+Math.round(c.raw/t*100)+'%)';}}}},
    scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(59,111,232,0.06)'},ticks:{precision:0},beginAtZero:true}}}});}
function dT(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.turnData;
  new Chart(el,{type:'line',data:{labels:d.map(function(r){return r.label;}),datasets:[
    {label:'Turnover %',data:d.map(function(r){return r.rate;}),borderColor:C.R,backgroundColor:'rgba(244,63,94,0.10)',tension:0.4,fill:true,pointRadius:4,pointBackgroundColor:C.R,borderWidth:2.5},
    {label:'15% Threshold',data:d.map(function(){return 15;}),borderColor:C.A,borderDash:[6,4],borderWidth:2,pointRadius:0,fill:false}
  ]},options:{responsive:true,maintainAspectRatio:false,
    plugins:{legend:{display:true,position:'top',labels:{usePointStyle:true,pointStyle:'circle',padding:16}},tooltip:{mode:'index',intersect:false,callbacks:{label:function(c){return' '+c.dataset.label+': '+c.raw+'%';}}}},
    scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(15,22,41,0.06)'},ticks:{callback:function(v){return v+'%';}},beginAtZero:true}}}});}
function dDT(id){var el=g(id);if(!el)return;sd(id);var dp=window.__an.deptData.slice(0,6);var rates=[18.2,14.5,9.8,12.1,7.4,11.6];
  var cols=dp.map(function(_,i){return i===0?C.R:(rates[i]>12?C.A:C.G);});
  new Chart(el,{type:'bar',data:{labels:dp.map(function(r){return r.label;}),datasets:[{data:rates.slice(0,dp.length),backgroundColor:cols,borderRadius:6,borderSkipped:false}]},
    options:{responsive:true,maintainAspectRatio:false,plugins:{tooltip:{callbacks:{label:function(c){return' '+c.raw+'% turnover';}}}},
    scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(15,22,41,0.06)'},ticks:{callback:function(v){return v+'%';}},beginAtZero:true}}}});}
function dN(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.nationalityData;
  new Chart(el,{type:'doughnut',data:{labels:d.map(function(r){return r.label;}),datasets:[{data:d.map(function(r){return r.value;}),backgroundColor:[C.I,C.T,C.R,C.A,C.G,C.P],borderWidth:0,cutout:'65%'}]},
    options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:true,position:'bottom',labels:{usePointStyle:true,boxWidth:8,padding:12}}}}});}
function dSG(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.skillGap.slice(0,5);
  new Chart(el,{type:'bar',data:{labels:d.map(function(s){return s.skill;}),datasets:[
    {label:'Have',data:d.map(function(s){return s.have;}),backgroundColor:'rgba(59,111,232,0.75)',borderRadius:5},
    {label:'Gap',data:d.map(function(s){return s.gap;}),backgroundColor:d.map(function(s){return s.gap>=8?'rgba(244,63,94,0.7)':(s.gap>=3?'rgba(245,158,11,0.7)':'rgba(16,185,129,0.7)');}),borderRadius:5}
  ]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:true,position:'top',labels:{usePointStyle:true,pointStyle:'circle'}}},
    scales:{x:{stacked:true,grid:{color:'rgba(59,111,232,0.06)'},ticks:{precision:0}},y:{stacked:true,grid:{display:false},ticks:{font:{size:11}}}}}});}
function dP(id){var el=g(id);if(!el)return;sd(id);var d=window.__an.predicted;
  new Chart(el,{type:'line',data:{labels:d.map(function(r){return r.label;}),datasets:[
    {label:'Base',data:d.map(function(r){return r.projected;}),borderColor:C.I,backgroundColor:'rgba(59,111,232,0.06)',tension:0.4,fill:true,pointRadius:4,borderWidth:2.5},
    {label:'Optimistic',data:d.map(function(r){return r.optimistic;}),borderColor:C.G,borderDash:[5,3],pointRadius:3,fill:false,tension:0.4,borderWidth:2},
    {label:'Conservative',data:d.map(function(r){return r.conservative;}),borderColor:C.R,borderDash:[5,3],pointRadius:3,fill:false,tension:0.4,borderWidth:2}
  ]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:true,position:'top',labels:{usePointStyle:true,pointStyle:'circle',padding:16}},tooltip:{mode:'index',intersect:false}},
    scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(59,111,232,0.06)'},ticks:{precision:0}}}}});}
function initCharts(){
  if(typeof Chart==='undefined') return;
  Chart.defaults.font.family="'DM Sans',system-ui,sans-serif";
  Chart.defaults.font.size=12;
  Chart.defaults.color='#6B7094';
  Chart.defaults.plugins.legend.display=false;
  dHE('hireExitChart');dHE('hireExitChart2');
  dD('deptChart');
  dG('genderChart');dG('genderChart2');
  dA('ageChart');dA('ageChart2');
  dT('turnoverChart');
  dDT('deptTurnoverChart');
  dSG('skillGapChart');
  dN('nationalityChart');
  dP('predictChart');
}
window.initAnalyticsCharts=initCharts;
document.addEventListener('livewire:updated',function(){requestAnimationFrame(function(){setTimeout(initCharts,80);});});
initCharts();
})();
</script>

</div>
BLADE;

$content .= $script;
file_put_contents($file, $content);
echo 'Done: ' . strlen($content) . ' bytes, ' . substr_count($content, "\n") . " lines\n";
