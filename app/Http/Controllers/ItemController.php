<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\KategoriItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Item::where('pengguna_id',Auth::user()->id)->paginate(10);
        return response()->view('item.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {   
        $kategoris = KategoriItem::where('pengguna_id',Auth::user()->id)->get();
        $colors = [
            "#F44336",
            "#2196F3",
            "#4CAF50",
            "#FFEB3B",
            "#9C27B0",
            "#FF9800",
            "#795548",
            "#9E9E9E",
        ];
        $bentukItems = [
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 47.999996 48" height="48" width="48" version="1.1" y="0px" x="0px" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"><metadata><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/><dc:title/></cc:Work></rdf:RDF></metadata><style type="text/css"> .st0{fill:#FFFFFF;stroke:#000000;stroke-miterlimit:10;} </style><path id="XMLID_1_" style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;solid-color:#000000;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;text-orientation:mixed;isolation:auto;text-transform:none" d="m1.6094 0c-0.88266 0-1.6094 0.72674-1.6094 1.6094v44.781c0 0.883 0.72674 1.61 1.6094 1.61h44.781c0.883 0 1.61-0.727 1.61-1.609v-44.782c0-0.88226-0.727-1.609-1.609-1.609zm0 1h44.781c0.347 0 0.61 0.2633 0.61 0.6094v44.781c0 0.347-0.263 0.61-0.609 0.61h-44.782c-0.3457 0-0.609-0.263-0.609-0.609v-44.782c0-0.3457 0.2633-0.609 0.6094-0.609z" fill-opacity="0.54"/></svg>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 48.000004 48" height="48" width="48" version="1.1" y="0px" x="0px" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"><metadata><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/><dc:title/></cc:Work></rdf:RDF></metadata><style type="text/css"> .st0{display:none;fill:#FFFFFF;stroke:#000000;stroke-miterlimit:10;} .st1{fill:#FFFFFF;stroke:#202021;stroke-miterlimit:10;} </style><rect id="XMLID_1_" y="-29.528" display="none" height="112" width="112" stroke="#000" stroke-miterlimit="10" x="-32.794" class="st0" fill="#fff"/><path id="XMLID_2_" style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;solid-color:#000000;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;text-orientation:mixed;isolation:auto;text-transform:none" d="m24 0c-13.249 0-24 10.751-24 24s10.751 24 24 24 24-10.751 24-24-10.751-24-24-24zm0 1c12.709 0 23 10.291 23 23s-10.291 23-23 23-23-10.291-23-23 10.291-23 23-23z" fill-opacity="0.54"/></svg>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" height="48.012" width="48.015" version="1.1" y="0px" x="0px" xmlns:cc="http://creativecommons.org/ns#" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48.014569 48.01212" xmlns:dc="http://purl.org/dc/elements/1.1/"><metadata><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/><dc:title/></cc:Work></rdf:RDF></metadata><style type="text/css"> .st0{display:none;fill:#FFFFFF;stroke:#000000;stroke-miterlimit:10;} .st1{display:none;fill:#FFFFFF;stroke:#202021;stroke-miterlimit:10;} .st2{fill:#FFFFFF;} .st3{fill:none;stroke:#202021;stroke-miterlimit:10;} </style><g stroke-miterlimit="10" transform="translate(-.0000058262 .010707)" fill="#fff"><rect id="XMLID_1_" y="-32.336" display="none" height="112" width="112" stroke="#000" x="-32.236" class="st0"/><circle id="XMLID_2_" class="st1" stroke="#202021" cy="23.664" cx="23.764" r="56" display="none"/><polygon id="XMLID_3_" display="none" transform="translate(-32.236,-32.336)" stroke="#202021" points="0.5 77.2 0.5 32.4 33 0.7 79 0.7 111.5 32.4 111.5 77.2 79 111.5 33 111.5" class="st1"/></g><image id="XMLID_6_" display="none" xlink:href="/media/ivan/Works/UMG/LPOS/elements/forms/2516832A.jpg" height="110.99" width="109.99" y="-20.772" x="-23.946"/><path id="XMLID_16_" style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;text-orientation:mixed;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;solid-color:#000000;isolation:auto;text-transform:none" d="m24.03 0.000010199c-0.351-0.0011515-0.708 0.1356-0.974 0.40178l-0.0017 0.002527-0.0025 0.002527-1.5311 1.5718c-0.14936 0.14944-0.55123 0.19481-0.78692 0.077544l-1.8868-1.0479-0.0017-0.0008409c-0.663-0.39547-1.479-0.13153-1.868 0.4506l-0.0076 0.011793-1.1036 1.8649c-0.12925 0.1909-0.52136 0.36265-0.73011 0.30577l-0.0025-0.000841-2.13-0.5535c-0.713-0.1942-1.481 0.2231-1.68 0.9443l-0.59522 2.1219c-0.05501 0.1832-0.39117 0.45401-0.58762 0.45401h-2.2178c-0.74211 0-1.3532 0.61048-1.3532 1.352v2.2162c0 0.22651-0.21337 0.52129-0.44262 0.58374h-0.00168l-2.1389 0.59892-0.00422 0.000863c-0.68638 0.20572-1.1366 0.9332-0.93666 1.6729l0.55391 2.1311 0.0008417 0.0034c0.057109 0.2092-0.10791 0.56312-0.29592 0.65701l-0.015175 0.0084-1.9037 1.1237-0.011803 0.0076c-0.59742 0.39789-0.78946 1.1921-0.46874 1.8329l0.005059 0.0093 1.0758 1.9349 0.00422 0.0076c0.12476 0.20774 0.069173 0.58878-0.095267 0.75306l-0.00253 0.0025-1.4956 1.5373 0.029508-0.0278c-0.57229 0.50028-0.55736 1.3907-0.02445 1.9231l1.5336 1.5743 0.00253 0.0025c0.14954 0.1494 0.19411 0.55031 0.076719 0.78592-0.0001247 0.00025 0.000125 0.000604 0 0.000862l-1.0479 1.8843c-0.39729 0.6615-0.13297 1.4782 0.45022 1.8666l0.01096 0.0076 1.8666 1.1018c0.19132 0.12874 0.36301 0.52159 0.30604 0.73033l-0.0008418 0.0025-0.55391 2.1286c-0.0000782 0.000287 0.0000781 0.000561 0 0.000863-0.19425 0.71342 0.22458 1.4807 0.94849 1.6779l2.1212 0.59301c0.18342 0.05497 0.45441 0.3909 0.45441 0.5871v2.2162c0 0.74146 0.61101 1.3528 1.3532 1.3528h2.2182c0.22678 0 0.52175 0.2124 0.58425 0.44137l0.000863 0.0017 0.59858 2.137 0.0017 0.0043c0.20624 0.68681 0.93541 1.137 1.6769 0.93502l2.1364-0.55428 0.0093-0.0026c0.13639-0.04089 0.54778 0.11857 0.67615 0.30998 0.000132 0.000199 0.000691-0.000198 0.000863 0l1.1019 1.8641 0.0076 0.01095c0.39828 0.59685 1.1923 0.78872 1.8337 0.46833l0.01012-0.005 1.9366-1.0748 0.0076-0.0043c0.20796-0.12466 0.58926-0.0691 0.75372 0.09519l0.0025 0.0026 1.5808 1.5364-0.02782-0.02864c0.50077 0.57175 1.3918 0.55682 1.9248 0.02441l1.5766-1.5322 0.0025-0.0026c0.14954-0.1494 0.55076-0.19394 0.78661-0.07666h0.000863l1.886 1.047c0.66212 0.3969 1.4795 0.13283 1.8683-0.44982l0.0076-0.01095 1.1196-1.8928 0.0034-0.0059c0.08038-0.14455 0.45911-0.32914 0.66856-0.27208l0.0025 0.000863 2.1305 0.55256c0.71431 0.19462 1.4828-0.22325 1.6803-0.94679l0.5944-2.1194c0.05501-0.1832 0.39032-0.45319 0.5868-0.45319h2.219c0.74211 0 1.3532-0.61134 1.3532-1.3528v-2.2162c0-0.22651 0.21253-0.52043 0.44176-0.58292l0.0017-0.000863 2.1397-0.59806 0.0043-0.0017c0.68742-0.20603 1.1381-0.93458 0.93584-1.6754l-0.55477-2.1345-0.0035-0.0093c-0.04088-0.13615 0.11792-0.54712 0.30941-0.67556l1.8674-1.1018 0.01097-0.0076c0.59742-0.39789 0.78946-1.1913 0.46874-1.8321l-0.0051-0.01011-1.0758-1.9349-0.0043-0.0067c-0.12476-0.20774-0.06917-0.5896 0.09527-0.75388l0.0026-0.0025 1.5378-1.5794-0.02866 0.0278c0.57148-0.4996 0.55684-1.3879 0.02611-1.9205l-1.5352-1.5768-0.0026-0.0025c-0.14954-0.1494-0.19411-0.55031-0.07672-0.78592 0.000125-0.00025-0.000125-0.000604 0-0.000862l1.0479-1.8843c0.39728-0.6615 0.13297-1.4782-0.45022-1.8666l-0.01096-0.0076-1.8952-1.1187-0.0059-0.0034c-0.147-0.077-0.331-0.454-0.273-0.663v-0.0034l0.55391-2.1278c0.19458-0.71278-0.22254-1.4803-0.94508-1.6788l-0.0026-0.000863-2.1212-0.59301c-0.18993-0.05607-0.46101-0.39203-0.46101-0.58827v-2.2168c0-0.74146-0.61102-1.352-1.3532-1.352h-2.2187c-0.22678 0-0.52093-0.2124-0.58343-0.44137l-0.000863-0.00168-0.59858-2.1379-0.0017-0.00421c-0.207-0.6865-0.936-1.1368-1.677-0.9347l-2.1305 0.55342-0.0025 0.000841c-0.21 0.057-0.565-0.108-0.659-0.2958l-0.0076-0.016004-1.1255-1.902-0.0076-0.010951c-0.398-0.59681-1.193-0.78869-1.834-0.46829l-0.0093 0.005054-1.9366 1.0748-0.0076 0.00421c-0.20806 0.12468-0.58922 0.069134-0.75368-0.095183l-0.0025-0.00253-1.5808-1.5373 0.02698 0.029482c-0.251-0.28585-0.598-0.42505-0.95-0.42621zm0.19728 1.0841 0.01349 0.015162 1.5926 1.5491-0.0042-0.00505c0.51816 0.51767 1.3309 0.63195 1.9762 0.24512l1.887-1.0471h0.0017c0.21074-0.10433 0.43762-0.040647 0.55136 0.12804l1.096 1.8532-0.01602-0.030324c0.33264 0.66465 1.0869 1.0107 1.816 0.81201l2.1305-0.5526 0.0025-0.000841c0.19707-0.053699 0.40637 0.092126 0.45609 0.25776l0.59353 2.1194c0.19347 0.70872 0.83695 1.1776 1.5488 1.1776h2.219c0.19646 0 0.35325 0.15672 0.35325 0.35294v2.2164c0 0.74146 0.49697 1.3441 1.1668 1.5448l0.0042 0.000862 2.1389 0.59892h0.0017c0.2144 0.05842 0.30818 0.22746 0.24702 0.45151l-0.000863 0.0034-0.55391 2.1278c-0.19875 0.72809 0.12783 1.4582 0.75035 1.8043 0.000363 0.000202 0.000432 0.000647 0.000864 0.000863l1.8447 1.0883c0.18318 0.12322 0.25922 0.3287 0.14501 0.51887l-0.0043 0.0076-1.0758 1.934-0.0051 0.01011c-0.30877 0.61695-0.26817 1.4083 0.26473 1.9408l1.5336 1.5743 0.0026 0.0025c0.1497 0.14956 0.13392 0.3677 0.02361 0.46414l-0.01433 0.01348-1.5454 1.5861c-0.51816 0.51767-0.63337 1.3298-0.24618 1.9744l1.0479 1.8843v0.0017c0.10442 0.21051 0.04157 0.43723-0.1273 0.55087l-1.8666 1.1026-0.01178 0.0076c-0.57605 0.38368-0.92828 1.0789-0.71323 1.795l0.55054 2.1159 0.000863 0.0034c0.05374 0.19684-0.09299 0.40516-0.25883 0.45487l-2.1212 0.59387c-0.70935 0.19327-1.1786 0.83621-1.1786 1.5474v2.2162c0 0.19622-0.15679 0.35294-0.35325 0.35294h-2.221c-0.74211 0-1.3444 0.49658-1.5454 1.1658l-0.000864 0.0042-0.59945 2.1379v0.0017c-0.05846 0.21415-0.22845 0.30708-0.45272 0.24596l-0.0025-0.000863-2.1305-0.55342c-0.72916-0.19867-1.4597 0.12787-1.8059 0.75051l-1.0901 1.843c-0.12333 0.18299-0.32896 0.25901-0.51933 0.14488l-0.0076-0.0043-1.9366-1.0748-0.0093-0.005c-0.61753-0.30847-1.4096-0.2679-1.9425 0.2645l0.0042-0.005-1.5808 1.5373-0.0025 0.0017c-0.1497 0.14956-0.36802 0.13463-0.46455 0.02441l-0.01265-0.01518-1.5884-1.5432c-0.518-0.519-1.331-0.634-1.976-0.247l-1.886 1.047c-0.000561 0.000281-0.0011-0.000276-0.0017 0-0.21074 0.10434-0.43762 0.04149-0.55136-0.12719l-1.1036-1.8649-0.0076-0.01177c-0.385-0.576-1.08-0.928-1.797-0.713l-2.1187 0.55005-0.0025 0.000863c-0.19707 0.0537-0.40637-0.09296-0.45609-0.2586l-0.594-2.118c-0.194-0.714-0.838-1.184-1.55-1.184h-2.2182c-0.19646 0-0.35325-0.15672-0.35325-0.35294v-2.216c0-0.74146-0.49697-1.3433-1.1668-1.544l-0.00423-0.0017-2.1397-0.59806-0.00168-0.000862c-0.2147-0.058-0.3076-0.227-0.2465-0.451l0.0008417-0.0034 0.55391-2.1278c0.1986-0.729-0.1407-1.443-0.7167-1.827l-0.011803-0.0076-1.8674-1.1026c-0.1833-0.123-0.2602-0.328-0.146-0.518l0.00422-0.0076 1.0766-1.9349 0.00422-0.0093c0.3089-0.617 0.2691-1.408-0.2638-1.94l0.00506 0.0042-1.5387-1.5794-0.00253-0.0025c-0.14973-0.15-0.13479-0.367-0.0245-0.464l0.015176-0.01348 1.5024-1.544c0.51812-0.51797 0.63333-1.3301 0.24613-1.9744l-1.0479-1.8847c-0.0002795-0.000561 0.0002772-0.0011 0-0.0017-0.10442-0.21051-0.041554-0.43723 0.12731-0.55087l1.8556-1.0951-0.031194 0.01685c0.66532-0.33207 1.0124-1.0868 0.81381-1.8152l-0.55391-2.1278-0.0008418-0.0034c-0.0536-0.196 0.0931-0.405 0.2589-0.454l2.1212-0.593c0.7094-0.194 1.1787-0.837 1.1787-1.549v-2.2159c0-0.19622 0.15679-0.35294 0.35325-0.35294h2.2182c0.74211 0 1.3453-0.49658 1.5462-1.1658l0.000863-0.00423 0.59945-2.137v-0.00168c0.05846-0.21415 0.22844-0.30708 0.45272-0.24596l0.0025 0.000841 2.1305 0.5526c0.72912 0.19866 1.4438-0.14046 1.8278-0.71601l0.0076-0.010951 1.1019-1.8641 0.000863-0.000841c0.123-0.1838 0.33-0.2609 0.52-0.1466l0.0067 0.00421 1.9366 1.0748 0.01012 0.00505c0.61753 0.30846 1.4096 0.2679 1.9425-0.2645l0.0025-0.00169 1.5327-1.5752c0.1497-0.14956 0.36802-0.13463 0.46455-0.024428z" fill-opacity="0.54"/></svg>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Created with Inkscape (http://www.inkscape.org/) --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" height="48" width="48" version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" viewBox="0 0 12.7 12.7"> <metadata> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/> <dc:title/> </cc:Work> </rdf:RDF> </metadata> <g transform="translate(0 -284.3)"> <path style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;solid-color:#000000;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;text-orientation:mixed;isolation:auto;text-transform:none" d="m12.698 290.68a0.13227 0.13227 0 0 0 -0.01541 -0.0436l-3.1109-5.3825a0.13227 0.13227 0 0 0 -0.11294 -0.0668h-6.2173a0.13227 0.13227 0 0 0 -0.1155 0.0668l-3.1083 5.3825a0.13227 0.13227 0 0 0 0 0.13347l3.1083 5.385a0.13227 0.13227 0 0 0 0.1155 0.0642h6.2167a0.13227 0.13227 0 0 0 0.11294 -0.0642l3.1109-5.385a0.13227 0.13227 0 0 0 0.01541 -0.0899zm-0.28491 0.0231-3.0313 5.2516h-6.0654l-3.0313-5.25 3.0313-5.25h6.0653z" fill-opacity="0.54"/> </g> </svg>'
        ];
        return response()->view('item.create',compact('kategoris','colors','bentukItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {   
        DB::beginTransaction();
        try {
            $gambar = null;
            if ($request->hasFile('gambar_item_file')) {
                //save image to storage
                $gambar = $request->file('gambar_item_file')->store('gambar_item');
            }
            $sku = $request->sku;
            if($sku == null){
                $sku = 10000+Item::where('pengguna_id',$request->user()->id)->count()+1;
            }
            $item = Item::create([
                'pengguna_id'=>Auth::user()->id,
                'kategori_item_id'=>$request->kategori_item_id,
                'nama_item'=>$request->nama_item,
                'warna_item'=>$request->warna_item,
                'bentuk_item'=>$request->bentuk_item ?? 0,
                'biaya_item'=>str_replace("Rp ","",str_replace(".","",$request->biaya_item)),
                'harga_item'=>str_replace("Rp ","",str_replace(".","",$request->harga_item)),
                'tipe_jual'=>$request->tipe_jual,
                'sku'=>$sku,
                'barcode'=>$request->barcode,
                'gambar_item' => $gambar,
            ]);
            if($request->has('lacak_stok') && $request->lacak_stok){
                $item->update([
                    'stok'=>$request->stok
                ]);
            }
            if($request->pengenal == "warna_dan_bentuk"){
                $item->update([
                    'warna_item'=>$request->warna_item
                ]);
            }
            DB::commit();
            return redirect()->route('item.index')->with('success','Berhasil menambahkan item');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item): Response
    {
        $kategoris = KategoriItem::where('pengguna_id',Auth::user()->id)->get();
        $colors = [
            "#F44336",
            "#2196F3",
            "#4CAF50",
            "#FFEB3B",
            "#9C27B0",
            "#FF9800",
            "#795548",
            "#9E9E9E",
        ];
        $bentukItems = [
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 47.999996 48" height="48" width="48" version="1.1" y="0px" x="0px" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"><metadata><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/><dc:title/></cc:Work></rdf:RDF></metadata><style type="text/css"> .st0{fill:#FFFFFF;stroke:#000000;stroke-miterlimit:10;} </style><path id="XMLID_1_" style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;solid-color:#000000;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;text-orientation:mixed;isolation:auto;text-transform:none" d="m1.6094 0c-0.88266 0-1.6094 0.72674-1.6094 1.6094v44.781c0 0.883 0.72674 1.61 1.6094 1.61h44.781c0.883 0 1.61-0.727 1.61-1.609v-44.782c0-0.88226-0.727-1.609-1.609-1.609zm0 1h44.781c0.347 0 0.61 0.2633 0.61 0.6094v44.781c0 0.347-0.263 0.61-0.609 0.61h-44.782c-0.3457 0-0.609-0.263-0.609-0.609v-44.782c0-0.3457 0.2633-0.609 0.6094-0.609z" fill-opacity="0.54"/></svg>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 48.000004 48" height="48" width="48" version="1.1" y="0px" x="0px" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"><metadata><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/><dc:title/></cc:Work></rdf:RDF></metadata><style type="text/css"> .st0{display:none;fill:#FFFFFF;stroke:#000000;stroke-miterlimit:10;} .st1{fill:#FFFFFF;stroke:#202021;stroke-miterlimit:10;} </style><rect id="XMLID_1_" y="-29.528" display="none" height="112" width="112" stroke="#000" stroke-miterlimit="10" x="-32.794" class="st0" fill="#fff"/><path id="XMLID_2_" style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;solid-color:#000000;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;text-orientation:mixed;isolation:auto;text-transform:none" d="m24 0c-13.249 0-24 10.751-24 24s10.751 24 24 24 24-10.751 24-24-10.751-24-24-24zm0 1c12.709 0 23 10.291 23 23s-10.291 23-23 23-23-10.291-23-23 10.291-23 23-23z" fill-opacity="0.54"/></svg>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" height="48.012" width="48.015" version="1.1" y="0px" x="0px" xmlns:cc="http://creativecommons.org/ns#" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48.014569 48.01212" xmlns:dc="http://purl.org/dc/elements/1.1/"><metadata><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/><dc:title/></cc:Work></rdf:RDF></metadata><style type="text/css"> .st0{display:none;fill:#FFFFFF;stroke:#000000;stroke-miterlimit:10;} .st1{display:none;fill:#FFFFFF;stroke:#202021;stroke-miterlimit:10;} .st2{fill:#FFFFFF;} .st3{fill:none;stroke:#202021;stroke-miterlimit:10;} </style><g stroke-miterlimit="10" transform="translate(-.0000058262 .010707)" fill="#fff"><rect id="XMLID_1_" y="-32.336" display="none" height="112" width="112" stroke="#000" x="-32.236" class="st0"/><circle id="XMLID_2_" class="st1" stroke="#202021" cy="23.664" cx="23.764" r="56" display="none"/><polygon id="XMLID_3_" display="none" transform="translate(-32.236,-32.336)" stroke="#202021" points="0.5 77.2 0.5 32.4 33 0.7 79 0.7 111.5 32.4 111.5 77.2 79 111.5 33 111.5" class="st1"/></g><image id="XMLID_6_" display="none" xlink:href="/media/ivan/Works/UMG/LPOS/elements/forms/2516832A.jpg" height="110.99" width="109.99" y="-20.772" x="-23.946"/><path id="XMLID_16_" style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;text-orientation:mixed;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;solid-color:#000000;isolation:auto;text-transform:none" d="m24.03 0.000010199c-0.351-0.0011515-0.708 0.1356-0.974 0.40178l-0.0017 0.002527-0.0025 0.002527-1.5311 1.5718c-0.14936 0.14944-0.55123 0.19481-0.78692 0.077544l-1.8868-1.0479-0.0017-0.0008409c-0.663-0.39547-1.479-0.13153-1.868 0.4506l-0.0076 0.011793-1.1036 1.8649c-0.12925 0.1909-0.52136 0.36265-0.73011 0.30577l-0.0025-0.000841-2.13-0.5535c-0.713-0.1942-1.481 0.2231-1.68 0.9443l-0.59522 2.1219c-0.05501 0.1832-0.39117 0.45401-0.58762 0.45401h-2.2178c-0.74211 0-1.3532 0.61048-1.3532 1.352v2.2162c0 0.22651-0.21337 0.52129-0.44262 0.58374h-0.00168l-2.1389 0.59892-0.00422 0.000863c-0.68638 0.20572-1.1366 0.9332-0.93666 1.6729l0.55391 2.1311 0.0008417 0.0034c0.057109 0.2092-0.10791 0.56312-0.29592 0.65701l-0.015175 0.0084-1.9037 1.1237-0.011803 0.0076c-0.59742 0.39789-0.78946 1.1921-0.46874 1.8329l0.005059 0.0093 1.0758 1.9349 0.00422 0.0076c0.12476 0.20774 0.069173 0.58878-0.095267 0.75306l-0.00253 0.0025-1.4956 1.5373 0.029508-0.0278c-0.57229 0.50028-0.55736 1.3907-0.02445 1.9231l1.5336 1.5743 0.00253 0.0025c0.14954 0.1494 0.19411 0.55031 0.076719 0.78592-0.0001247 0.00025 0.000125 0.000604 0 0.000862l-1.0479 1.8843c-0.39729 0.6615-0.13297 1.4782 0.45022 1.8666l0.01096 0.0076 1.8666 1.1018c0.19132 0.12874 0.36301 0.52159 0.30604 0.73033l-0.0008418 0.0025-0.55391 2.1286c-0.0000782 0.000287 0.0000781 0.000561 0 0.000863-0.19425 0.71342 0.22458 1.4807 0.94849 1.6779l2.1212 0.59301c0.18342 0.05497 0.45441 0.3909 0.45441 0.5871v2.2162c0 0.74146 0.61101 1.3528 1.3532 1.3528h2.2182c0.22678 0 0.52175 0.2124 0.58425 0.44137l0.000863 0.0017 0.59858 2.137 0.0017 0.0043c0.20624 0.68681 0.93541 1.137 1.6769 0.93502l2.1364-0.55428 0.0093-0.0026c0.13639-0.04089 0.54778 0.11857 0.67615 0.30998 0.000132 0.000199 0.000691-0.000198 0.000863 0l1.1019 1.8641 0.0076 0.01095c0.39828 0.59685 1.1923 0.78872 1.8337 0.46833l0.01012-0.005 1.9366-1.0748 0.0076-0.0043c0.20796-0.12466 0.58926-0.0691 0.75372 0.09519l0.0025 0.0026 1.5808 1.5364-0.02782-0.02864c0.50077 0.57175 1.3918 0.55682 1.9248 0.02441l1.5766-1.5322 0.0025-0.0026c0.14954-0.1494 0.55076-0.19394 0.78661-0.07666h0.000863l1.886 1.047c0.66212 0.3969 1.4795 0.13283 1.8683-0.44982l0.0076-0.01095 1.1196-1.8928 0.0034-0.0059c0.08038-0.14455 0.45911-0.32914 0.66856-0.27208l0.0025 0.000863 2.1305 0.55256c0.71431 0.19462 1.4828-0.22325 1.6803-0.94679l0.5944-2.1194c0.05501-0.1832 0.39032-0.45319 0.5868-0.45319h2.219c0.74211 0 1.3532-0.61134 1.3532-1.3528v-2.2162c0-0.22651 0.21253-0.52043 0.44176-0.58292l0.0017-0.000863 2.1397-0.59806 0.0043-0.0017c0.68742-0.20603 1.1381-0.93458 0.93584-1.6754l-0.55477-2.1345-0.0035-0.0093c-0.04088-0.13615 0.11792-0.54712 0.30941-0.67556l1.8674-1.1018 0.01097-0.0076c0.59742-0.39789 0.78946-1.1913 0.46874-1.8321l-0.0051-0.01011-1.0758-1.9349-0.0043-0.0067c-0.12476-0.20774-0.06917-0.5896 0.09527-0.75388l0.0026-0.0025 1.5378-1.5794-0.02866 0.0278c0.57148-0.4996 0.55684-1.3879 0.02611-1.9205l-1.5352-1.5768-0.0026-0.0025c-0.14954-0.1494-0.19411-0.55031-0.07672-0.78592 0.000125-0.00025-0.000125-0.000604 0-0.000862l1.0479-1.8843c0.39728-0.6615 0.13297-1.4782-0.45022-1.8666l-0.01096-0.0076-1.8952-1.1187-0.0059-0.0034c-0.147-0.077-0.331-0.454-0.273-0.663v-0.0034l0.55391-2.1278c0.19458-0.71278-0.22254-1.4803-0.94508-1.6788l-0.0026-0.000863-2.1212-0.59301c-0.18993-0.05607-0.46101-0.39203-0.46101-0.58827v-2.2168c0-0.74146-0.61102-1.352-1.3532-1.352h-2.2187c-0.22678 0-0.52093-0.2124-0.58343-0.44137l-0.000863-0.00168-0.59858-2.1379-0.0017-0.00421c-0.207-0.6865-0.936-1.1368-1.677-0.9347l-2.1305 0.55342-0.0025 0.000841c-0.21 0.057-0.565-0.108-0.659-0.2958l-0.0076-0.016004-1.1255-1.902-0.0076-0.010951c-0.398-0.59681-1.193-0.78869-1.834-0.46829l-0.0093 0.005054-1.9366 1.0748-0.0076 0.00421c-0.20806 0.12468-0.58922 0.069134-0.75368-0.095183l-0.0025-0.00253-1.5808-1.5373 0.02698 0.029482c-0.251-0.28585-0.598-0.42505-0.95-0.42621zm0.19728 1.0841 0.01349 0.015162 1.5926 1.5491-0.0042-0.00505c0.51816 0.51767 1.3309 0.63195 1.9762 0.24512l1.887-1.0471h0.0017c0.21074-0.10433 0.43762-0.040647 0.55136 0.12804l1.096 1.8532-0.01602-0.030324c0.33264 0.66465 1.0869 1.0107 1.816 0.81201l2.1305-0.5526 0.0025-0.000841c0.19707-0.053699 0.40637 0.092126 0.45609 0.25776l0.59353 2.1194c0.19347 0.70872 0.83695 1.1776 1.5488 1.1776h2.219c0.19646 0 0.35325 0.15672 0.35325 0.35294v2.2164c0 0.74146 0.49697 1.3441 1.1668 1.5448l0.0042 0.000862 2.1389 0.59892h0.0017c0.2144 0.05842 0.30818 0.22746 0.24702 0.45151l-0.000863 0.0034-0.55391 2.1278c-0.19875 0.72809 0.12783 1.4582 0.75035 1.8043 0.000363 0.000202 0.000432 0.000647 0.000864 0.000863l1.8447 1.0883c0.18318 0.12322 0.25922 0.3287 0.14501 0.51887l-0.0043 0.0076-1.0758 1.934-0.0051 0.01011c-0.30877 0.61695-0.26817 1.4083 0.26473 1.9408l1.5336 1.5743 0.0026 0.0025c0.1497 0.14956 0.13392 0.3677 0.02361 0.46414l-0.01433 0.01348-1.5454 1.5861c-0.51816 0.51767-0.63337 1.3298-0.24618 1.9744l1.0479 1.8843v0.0017c0.10442 0.21051 0.04157 0.43723-0.1273 0.55087l-1.8666 1.1026-0.01178 0.0076c-0.57605 0.38368-0.92828 1.0789-0.71323 1.795l0.55054 2.1159 0.000863 0.0034c0.05374 0.19684-0.09299 0.40516-0.25883 0.45487l-2.1212 0.59387c-0.70935 0.19327-1.1786 0.83621-1.1786 1.5474v2.2162c0 0.19622-0.15679 0.35294-0.35325 0.35294h-2.221c-0.74211 0-1.3444 0.49658-1.5454 1.1658l-0.000864 0.0042-0.59945 2.1379v0.0017c-0.05846 0.21415-0.22845 0.30708-0.45272 0.24596l-0.0025-0.000863-2.1305-0.55342c-0.72916-0.19867-1.4597 0.12787-1.8059 0.75051l-1.0901 1.843c-0.12333 0.18299-0.32896 0.25901-0.51933 0.14488l-0.0076-0.0043-1.9366-1.0748-0.0093-0.005c-0.61753-0.30847-1.4096-0.2679-1.9425 0.2645l0.0042-0.005-1.5808 1.5373-0.0025 0.0017c-0.1497 0.14956-0.36802 0.13463-0.46455 0.02441l-0.01265-0.01518-1.5884-1.5432c-0.518-0.519-1.331-0.634-1.976-0.247l-1.886 1.047c-0.000561 0.000281-0.0011-0.000276-0.0017 0-0.21074 0.10434-0.43762 0.04149-0.55136-0.12719l-1.1036-1.8649-0.0076-0.01177c-0.385-0.576-1.08-0.928-1.797-0.713l-2.1187 0.55005-0.0025 0.000863c-0.19707 0.0537-0.40637-0.09296-0.45609-0.2586l-0.594-2.118c-0.194-0.714-0.838-1.184-1.55-1.184h-2.2182c-0.19646 0-0.35325-0.15672-0.35325-0.35294v-2.216c0-0.74146-0.49697-1.3433-1.1668-1.544l-0.00423-0.0017-2.1397-0.59806-0.00168-0.000862c-0.2147-0.058-0.3076-0.227-0.2465-0.451l0.0008417-0.0034 0.55391-2.1278c0.1986-0.729-0.1407-1.443-0.7167-1.827l-0.011803-0.0076-1.8674-1.1026c-0.1833-0.123-0.2602-0.328-0.146-0.518l0.00422-0.0076 1.0766-1.9349 0.00422-0.0093c0.3089-0.617 0.2691-1.408-0.2638-1.94l0.00506 0.0042-1.5387-1.5794-0.00253-0.0025c-0.14973-0.15-0.13479-0.367-0.0245-0.464l0.015176-0.01348 1.5024-1.544c0.51812-0.51797 0.63333-1.3301 0.24613-1.9744l-1.0479-1.8847c-0.0002795-0.000561 0.0002772-0.0011 0-0.0017-0.10442-0.21051-0.041554-0.43723 0.12731-0.55087l1.8556-1.0951-0.031194 0.01685c0.66532-0.33207 1.0124-1.0868 0.81381-1.8152l-0.55391-2.1278-0.0008418-0.0034c-0.0536-0.196 0.0931-0.405 0.2589-0.454l2.1212-0.593c0.7094-0.194 1.1787-0.837 1.1787-1.549v-2.2159c0-0.19622 0.15679-0.35294 0.35325-0.35294h2.2182c0.74211 0 1.3453-0.49658 1.5462-1.1658l0.000863-0.00423 0.59945-2.137v-0.00168c0.05846-0.21415 0.22844-0.30708 0.45272-0.24596l0.0025 0.000841 2.1305 0.5526c0.72912 0.19866 1.4438-0.14046 1.8278-0.71601l0.0076-0.010951 1.1019-1.8641 0.000863-0.000841c0.123-0.1838 0.33-0.2609 0.52-0.1466l0.0067 0.00421 1.9366 1.0748 0.01012 0.00505c0.61753 0.30846 1.4096 0.2679 1.9425-0.2645l0.0025-0.00169 1.5327-1.5752c0.1497-0.14956 0.36802-0.13463 0.46455-0.024428z" fill-opacity="0.54"/></svg>',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <!-- Created with Inkscape (http://www.inkscape.org/) --> <svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" height="48" width="48" version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" viewBox="0 0 12.7 12.7"> <metadata> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/> <dc:title/> </cc:Work> </rdf:RDF> </metadata> <g transform="translate(0 -284.3)"> <path style="color-rendering:auto;text-decoration-color:#000000;color:#000000;font-variant-numeric:normal;shape-rendering:auto;font-variant-ligatures:normal;text-decoration-line:none;font-variant-position:normal;mix-blend-mode:normal;solid-color:#000000;font-feature-settings:normal;shape-padding:0;font-variant-alternates:normal;text-indent:0;dominant-baseline:auto;font-variant-caps:normal;image-rendering:auto;white-space:normal;text-decoration-style:solid;text-orientation:mixed;isolation:auto;text-transform:none" d="m12.698 290.68a0.13227 0.13227 0 0 0 -0.01541 -0.0436l-3.1109-5.3825a0.13227 0.13227 0 0 0 -0.11294 -0.0668h-6.2173a0.13227 0.13227 0 0 0 -0.1155 0.0668l-3.1083 5.3825a0.13227 0.13227 0 0 0 0 0.13347l3.1083 5.385a0.13227 0.13227 0 0 0 0.1155 0.0642h6.2167a0.13227 0.13227 0 0 0 0.11294 -0.0642l3.1109-5.385a0.13227 0.13227 0 0 0 0.01541 -0.0899zm-0.28491 0.0231-3.0313 5.2516h-6.0654l-3.0313-5.25 3.0313-5.25h6.0653z" fill-opacity="0.54"/> </g> </svg>'
        ];
        return response()->view('item.edit',[
            'kategoris'=>$kategoris,
            'colors'=>$colors,
            'bentukItems'=>$bentukItems,
            'data'=>$item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item): RedirectResponse
    {   
       
        $old_gambar = $item->gambar_item;
        $gambar = null;
        DB::beginTransaction();
        try {
            
            if ($request->hasFile('gambar_item_file') && $request->gambar_item_file != null) {
                //save image to storage
                $gambar = $request->file('gambar_item_file')->store('gambar_item_file');
            }
            
            $item->update([
                'kategori_item_id' => $request->kategori_item_id != 0 ? $request->kategori_item_id : null,
                'nama_item' => $request->nama_item,
                'biaya_item'=>str_replace("Rp ","",str_replace(".","",$request->biaya_item)),
                'harga_item'=>str_replace("Rp ","",str_replace(".","",$request->harga_item)),
                'sku' => $request->sku,
                'barcode' => $request->barcode,
                
                'tipe_jual' => $request->tipe_jual,
                'warna_item' => $request->warna_item,
                'bentuk_item'=>$request->bentuk_item ?? 0,
                'gambar_item' => $gambar ?? $old_gambar,
            ]);
            if($request->has('lacak_stok') && $request->lacak_stok){
                $item->update([
                    'lacak_stok'=>true,
                    'stok'=>$request->stok
                ]);
            }
         
            if($old_gambar != null && Storage::exists($old_gambar) && $gambar != null) Storage::delete($old_gambar);
            DB::commit();
            return redirect()->route('item.index')->with('success','Berhasil mengubah item');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {   
        DB::beginTransaction();
        try {
            $item->delete();
            DB::commit();
            return redirect()->route('item.index')->with('success','Item berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('item.index')->with('error','Item gagal dihapus');
        }
    }
}
