<script id="print-out-order-tmp" type="text-x-mustache-tmpl">
<head>
    <style type="text/css">
        table {
            background-color: transparent
        }

        caption {
            padding-top: 8px;
            padding-bottom: 8px;
            color: #777
        }

        caption, th {
            text-align: left
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 8px;
            line-height: 1.428571429;
            vertical-align: top;
            border-top: 1px solid #ddd
        }

        .table > thead > tr > th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd
        }

        .table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
            border-top: 0
        }

        .table > tbody + tbody {
            border-top: 2px solid #ddd
        }

        .table .table {
            background-color: #fff
        }

        .table-condensed > tbody > tr > td, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > td, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > thead > tr > th {
            padding: 5px
        }

        .table-bordered, .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border: 1px solid #ddd
        }

        .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border-bottom-width: 2px
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9
        }

        .table-hover > tbody > tr:hover {
            background-color: #f5f5f5
        }

        table col[class*=col-] {
            position: static;
            float: none;
            display: table-column
        }

        table td[class*=col-], table th[class*=col-] {
            position: static;
            float: none;
            display: table-cell
        }

        .table > tbody > tr.active > td, .table > tbody > tr.active > th, .table > tbody > tr > td.active, .table > tbody > tr > th.active, .table > tfoot > tr.active > td, .table > tfoot > tr.active > th, .table > tfoot > tr > td.active, .table > tfoot > tr > th.active, .table > thead > tr.active > td, .table > thead > tr.active > th, .table > thead > tr > td.active, .table > thead > tr > th.active {
            background-color: #f5f5f5
        }

        .table-hover > tbody > tr.active:hover > td, .table-hover > tbody > tr.active:hover > th, .table-hover > tbody > tr:hover > .active, .table-hover > tbody > tr > td.active:hover, .table-hover > tbody > tr > th.active:hover {
            background-color: #e8e8e8
        }

        .table > tbody > tr.success > td, .table > tbody > tr.success > th, .table > tbody > tr > td.success, .table > tbody > tr > th.success, .table > tfoot > tr.success > td, .table > tfoot > tr.success > th, .table > tfoot > tr > td.success, .table > tfoot > tr > th.success, .table > thead > tr.success > td, .table > thead > tr.success > th, .table > thead > tr > td.success, .table > thead > tr > th.success {
            background-color: #dff0d8
        }

        .table-hover > tbody > tr.success:hover > td, .table-hover > tbody > tr.success:hover > th, .table-hover > tbody > tr:hover > .success, .table-hover > tbody > tr > td.success:hover, .table-hover > tbody > tr > th.success:hover {
            background-color: #d0e9c6
        }

        .table > tbody > tr.info > td, .table > tbody > tr.info > th, .table > tbody > tr > td.info, .table > tbody > tr > th.info, .table > tfoot > tr.info > td, .table > tfoot > tr.info > th, .table > tfoot > tr > td.info, .table > tfoot > tr > th.info, .table > thead > tr.info > td, .table > thead > tr.info > th, .table > thead > tr > td.info, .table > thead > tr > th.info {
            background-color: #d9edf7
        }

        .table-hover > tbody > tr.info:hover > td, .table-hover > tbody > tr.info:hover > th, .table-hover > tbody > tr:hover > .info, .table-hover > tbody > tr > td.info:hover, .table-hover > tbody > tr > th.info:hover {
            background-color: #c4e3f3
        }

        .table > tbody > tr.warning > td, .table > tbody > tr.warning > th, .table > tbody > tr > td.warning, .table > tbody > tr > th.warning, .table > tfoot > tr.warning > td, .table > tfoot > tr.warning > th, .table > tfoot > tr > td.warning, .table > tfoot > tr > th.warning, .table > thead > tr.warning > td, .table > thead > tr.warning > th, .table > thead > tr > td.warning, .table > thead > tr > th.warning {
            background-color: #fcf8e3
        }

        .table-hover > tbody > tr.warning:hover > td, .table-hover > tbody > tr.warning:hover > th, .table-hover > tbody > tr:hover > .warning, .table-hover > tbody > tr > td.warning:hover, .table-hover > tbody > tr > th.warning:hover {
            background-color: #faf2cc
        }

        .table > tbody > tr.danger > td, .table > tbody > tr.danger > th, .table > tbody > tr > td.danger, .table > tbody > tr > th.danger, .table > tfoot > tr.danger > td, .table > tfoot > tr.danger > th, .table > tfoot > tr > td.danger, .table > tfoot > tr > th.danger, .table > thead > tr.danger > td, .table > thead > tr.danger > th, .table > thead > tr > td.danger, .table > thead > tr > th.danger {
            background-color: #f2dede
        }

        .table-hover > tbody > tr.danger:hover > td, .table-hover > tbody > tr.danger:hover > th, .table-hover > tbody > tr:hover > .danger, .table-hover > tbody > tr > td.danger:hover, .table-hover > tbody > tr > th.danger:hover {
            background-color: #ebcccc
        }

        .table-responsive {
            overflow-x: auto;
            min-height: .01%
        }

        @media screen and (max-width: 767px) {
            .table-responsive {
                width: 100%;
                margin-bottom: 15px;
                overflow-y: hidden;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border: 1px solid #ddd
            }

            .table-responsive > .table {
                margin-bottom: 0
            }

            .table-responsive > .table > tbody > tr > td, .table-responsive > .table > tbody > tr > th, .table-responsive > .table > tfoot > tr > td, .table-responsive > .table > tfoot > tr > th, .table-responsive > .table > thead > tr > td, .table-responsive > .table > thead > tr > th {
                white-space: nowrap
            }

            .table-responsive > .table-bordered {
                border: 0
            }

            .table-responsive > .table-bordered > tbody > tr > td:first-child, .table-responsive > .table-bordered > tbody > tr > th:first-child, .table-responsive > .table-bordered > tfoot > tr > td:first-child, .table-responsive > .table-bordered > tfoot > tr > th:first-child, .table-responsive > .table-bordered > thead > tr > td:first-child, .table-responsive > .table-bordered > thead > tr > th:first-child {
                border-left: 0
            }

            .table-responsive > .table-bordered > tbody > tr > td:last-child, .table-responsive > .table-bordered > tbody > tr > th:last-child, .table-responsive > .table-bordered > tfoot > tr > td:last-child, .table-responsive > .table-bordered > tfoot > tr > th:last-child, .table-responsive > .table-bordered > thead > tr > td:last-child, .table-responsive > .table-bordered > thead > tr > th:last-child {
                border-right: 0
            }

            .table-responsive > .table-bordered > tbody > tr:last-child > td, .table-responsive > .table-bordered > tbody > tr:last-child > th, .table-responsive > .table-bordered > tfoot > tr:last-child > td, .table-responsive > .table-bordered > tfoot > tr:last-child > th {
                border-bottom: 0
            }
        }

        .row {
            margin-left: -15px;
            margin-right: -15px
        }

        .row:after, .row:before {
            content: " ";
            display: table
        }

        .row:after {
            clear: both
        }

        .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px
        }

        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left
        }

        .col-xs-1 {
            width: 8.3333333333%
        }

        .col-xs-2 {
            width: 16.6666666667%
        }

        .col-xs-3 {
            width: 25%
        }

        .col-xs-4 {
            width: 33.3333333333%
        }

        .col-xs-5 {
            width: 41.6666666667%
        }

        .col-xs-6 {
            width: 50%
        }

        .col-xs-7 {
            width: 58.3333333333%
        }

        .col-xs-8 {
            width: 66.6666666667%
        }

        .col-xs-9 {
            width: 75%
        }

        .col-xs-10 {
            width: 83.3333333333%
        }

        .col-xs-11 {
            width: 91.6666666667%
        }

        .col-xs-12 {
            width: 100%
        }

        .col-xs-pull-0 {
            right: auto
        }

        .col-xs-pull-1 {
            right: 8.3333333333%
        }

        .col-xs-pull-2 {
            right: 16.6666666667%
        }

        .col-xs-pull-3 {
            right: 25%
        }

        .col-xs-pull-4 {
            right: 33.3333333333%
        }

        .col-xs-pull-5 {
            right: 41.6666666667%
        }

        .col-xs-pull-6 {
            right: 50%
        }

        .col-xs-pull-7 {
            right: 58.3333333333%
        }

        .col-xs-pull-8 {
            right: 66.6666666667%
        }

        .col-xs-pull-9 {
            right: 75%
        }

        .col-xs-pull-10 {
            right: 83.3333333333%
        }

        .col-xs-pull-11 {
            right: 91.6666666667%
        }

        .col-xs-pull-12 {
            right: 100%
        }

        .col-xs-push-0 {
            left: auto
        }

        .col-xs-push-1 {
            left: 8.3333333333%
        }

        .col-xs-push-2 {
            left: 16.6666666667%
        }

        .col-xs-push-3 {
            left: 25%
        }

        .col-xs-push-4 {
            left: 33.3333333333%
        }

        .col-xs-push-5 {
            left: 41.6666666667%
        }

        .col-xs-push-6 {
            left: 50%
        }

        .col-xs-push-7 {
            left: 58.3333333333%
        }

        .col-xs-push-8 {
            left: 66.6666666667%
        }

        .col-xs-push-9 {
            left: 75%
        }

        .col-xs-push-10 {
            left: 83.3333333333%
        }

        .col-xs-push-11 {
            left: 91.6666666667%
        }

        .col-xs-push-12 {
            left: 100%
        }

        .col-xs-offset-0 {
            margin-left: 0
        }

        .col-xs-offset-1 {
            margin-left: 8.3333333333%
        }

        .col-xs-offset-2 {
            margin-left: 16.6666666667%
        }

        .col-xs-offset-3 {
            margin-left: 25%
        }

        .col-xs-offset-4 {
            margin-left: 33.3333333333%
        }

        .col-xs-offset-5 {
            margin-left: 41.6666666667%
        }

        .col-xs-offset-6 {
            margin-left: 50%
        }

        .col-xs-offset-7 {
            margin-left: 58.3333333333%
        }

        .col-xs-offset-8 {
            margin-left: 66.6666666667%
        }

        .col-xs-offset-9 {
            margin-left: 75%
        }

        .col-xs-offset-10 {
            margin-left: 83.3333333333%
        }

        .col-xs-offset-11 {
            margin-left: 91.6666666667%
        }

        .col-xs-offset-12 {
            margin-left: 100%
        }

        @media (min-width: 768px) {
            .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                float: left
            }

            .col-sm-1 {
                width: 8.3333333333%
            }

            .col-sm-2 {
                width: 16.6666666667%
            }

            .col-sm-3 {
                width: 25%
            }

            .col-sm-4 {
                width: 33.3333333333%
            }

            .col-sm-5 {
                width: 41.6666666667%
            }

            .col-sm-6 {
                width: 50%
            }

            .col-sm-7 {
                width: 58.3333333333%
            }

            .col-sm-8 {
                width: 66.6666666667%
            }

            .col-sm-9 {
                width: 75%
            }

            .col-sm-10 {
                width: 83.3333333333%
            }

            .col-sm-11 {
                width: 91.6666666667%
            }

            .col-sm-12 {
                width: 100%
            }

            .col-sm-pull-0 {
                right: auto
            }

            .col-sm-pull-1 {
                right: 8.3333333333%
            }

            .col-sm-pull-2 {
                right: 16.6666666667%
            }

            .col-sm-pull-3 {
                right: 25%
            }

            .col-sm-pull-4 {
                right: 33.3333333333%
            }

            .col-sm-pull-5 {
                right: 41.6666666667%
            }

            .col-sm-pull-6 {
                right: 50%
            }

            .col-sm-pull-7 {
                right: 58.3333333333%
            }

            .col-sm-pull-8 {
                right: 66.6666666667%
            }

            .col-sm-pull-9 {
                right: 75%
            }

            .col-sm-pull-10 {
                right: 83.3333333333%
            }

            .col-sm-pull-11 {
                right: 91.6666666667%
            }

            .col-sm-pull-12 {
                right: 100%
            }

            .col-sm-push-0 {
                left: auto
            }

            .col-sm-push-1 {
                left: 8.3333333333%
            }

            .col-sm-push-2 {
                left: 16.6666666667%
            }

            .col-sm-push-3 {
                left: 25%
            }

            .col-sm-push-4 {
                left: 33.3333333333%
            }

            .col-sm-push-5 {
                left: 41.6666666667%
            }

            .col-sm-push-6 {
                left: 50%
            }

            .col-sm-push-7 {
                left: 58.3333333333%
            }

            .col-sm-push-8 {
                left: 66.6666666667%
            }

            .col-sm-push-9 {
                left: 75%
            }

            .col-sm-push-10 {
                left: 83.3333333333%
            }

            .col-sm-push-11 {
                left: 91.6666666667%
            }

            .col-sm-push-12 {
                left: 100%
            }

            .col-sm-offset-0 {
                margin-left: 0
            }

            .col-sm-offset-1 {
                margin-left: 8.3333333333%
            }

            .col-sm-offset-2 {
                margin-left: 16.6666666667%
            }

            .col-sm-offset-3 {
                margin-left: 25%
            }

            .col-sm-offset-4 {
                margin-left: 33.3333333333%
            }

            .col-sm-offset-5 {
                margin-left: 41.6666666667%
            }

            .col-sm-offset-6 {
                margin-left: 50%
            }

            .col-sm-offset-7 {
                margin-left: 58.3333333333%
            }

            .col-sm-offset-8 {
                margin-left: 66.6666666667%
            }

            .col-sm-offset-9 {
                margin-left: 75%
            }

            .col-sm-offset-10 {
                margin-left: 83.3333333333%
            }

            .col-sm-offset-11 {
                margin-left: 91.6666666667%
            }

            .col-sm-offset-12 {
                margin-left: 100%
            }
        }

        @media (min-width: 992px) {
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left
            }

            .col-md-1 {
                width: 8.3333333333%
            }

            .col-md-2 {
                width: 16.6666666667%
            }

            .col-md-3 {
                width: 25%
            }

            .col-md-4 {
                width: 33.3333333333%
            }

            .col-md-5 {
                width: 41.6666666667%
            }

            .col-md-6 {
                width: 50%
            }

            .col-md-7 {
                width: 58.3333333333%
            }

            .col-md-8 {
                width: 66.6666666667%
            }

            .col-md-9 {
                width: 75%
            }

            .col-md-10 {
                width: 83.3333333333%
            }

            .col-md-11 {
                width: 91.6666666667%
            }

            .col-md-12 {
                width: 100%
            }

            .col-md-pull-0 {
                right: auto
            }

            .col-md-pull-1 {
                right: 8.3333333333%
            }

            .col-md-pull-2 {
                right: 16.6666666667%
            }

            .col-md-pull-3 {
                right: 25%
            }

            .col-md-pull-4 {
                right: 33.3333333333%
            }

            .col-md-pull-5 {
                right: 41.6666666667%
            }

            .col-md-pull-6 {
                right: 50%
            }

            .col-md-pull-7 {
                right: 58.3333333333%
            }

            .col-md-pull-8 {
                right: 66.6666666667%
            }

            .col-md-pull-9 {
                right: 75%
            }

            .col-md-pull-10 {
                right: 83.3333333333%
            }

            .col-md-pull-11 {
                right: 91.6666666667%
            }

            .col-md-pull-12 {
                right: 100%
            }

            .col-md-push-0 {
                left: auto
            }

            .col-md-push-1 {
                left: 8.3333333333%
            }

            .col-md-push-2 {
                left: 16.6666666667%
            }

            .col-md-push-3 {
                left: 25%
            }

            .col-md-push-4 {
                left: 33.3333333333%
            }

            .col-md-push-5 {
                left: 41.6666666667%
            }

            .col-md-push-6 {
                left: 50%
            }

            .col-md-push-7 {
                left: 58.3333333333%
            }

            .col-md-push-8 {
                left: 66.6666666667%
            }

            .col-md-push-9 {
                left: 75%
            }

            .col-md-push-10 {
                left: 83.3333333333%
            }

            .col-md-push-11 {
                left: 91.6666666667%
            }

            .col-md-push-12 {
                left: 100%
            }

            .col-md-offset-0 {
                margin-left: 0
            }

            .col-md-offset-1 {
                margin-left: 8.3333333333%
            }

            .col-md-offset-2 {
                margin-left: 16.6666666667%
            }

            .col-md-offset-3 {
                margin-left: 25%
            }

            .col-md-offset-4 {
                margin-left: 33.3333333333%
            }

            .col-md-offset-5 {
                margin-left: 41.6666666667%
            }

            .col-md-offset-6 {
                margin-left: 50%
            }

            .col-md-offset-7 {
                margin-left: 58.3333333333%
            }

            .col-md-offset-8 {
                margin-left: 66.6666666667%
            }

            .col-md-offset-9 {
                margin-left: 75%
            }

            .col-md-offset-10 {
                margin-left: 83.3333333333%
            }

            .col-md-offset-11 {
                margin-left: 91.6666666667%
            }

            .col-md-offset-12 {
                margin-left: 100%
            }
        }

        @media (min-width: 1200px) {
            .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
                float: left
            }

            .col-lg-1 {
                width: 8.3333333333%
            }

            .col-lg-2 {
                width: 16.6666666667%
            }

            .col-lg-3 {
                width: 25%
            }

            .col-lg-4 {
                width: 33.3333333333%
            }

            .col-lg-5 {
                width: 41.6666666667%
            }

            .col-lg-6 {
                width: 50%
            }

            .col-lg-7 {
                width: 58.3333333333%
            }

            .col-lg-8 {
                width: 66.6666666667%
            }

            .col-lg-9 {
                width: 75%
            }

            .col-lg-10 {
                width: 83.3333333333%
            }

            .col-lg-11 {
                width: 91.6666666667%
            }

            .col-lg-12 {
                width: 100%
            }

            .col-lg-pull-0 {
                right: auto
            }

            .col-lg-pull-1 {
                right: 8.3333333333%
            }

            .col-lg-pull-2 {
                right: 16.6666666667%
            }

            .col-lg-pull-3 {
                right: 25%
            }

            .col-lg-pull-4 {
                right: 33.3333333333%
            }

            .col-lg-pull-5 {
                right: 41.6666666667%
            }

            .col-lg-pull-6 {
                right: 50%
            }

            .col-lg-pull-7 {
                right: 58.3333333333%
            }

            .col-lg-pull-8 {
                right: 66.6666666667%
            }

            .col-lg-pull-9 {
                right: 75%
            }

            .col-lg-pull-10 {
                right: 83.3333333333%
            }

            .col-lg-pull-11 {
                right: 91.6666666667%
            }

            .col-lg-pull-12 {
                right: 100%
            }

            .col-lg-push-0 {
                left: auto
            }

            .col-lg-push-1 {
                left: 8.3333333333%
            }

            .col-lg-push-2 {
                left: 16.6666666667%
            }

            .col-lg-push-3 {
                left: 25%
            }

            .col-lg-push-4 {
                left: 33.3333333333%
            }

            .col-lg-push-5 {
                left: 41.6666666667%
            }

            .col-lg-push-6 {
                left: 50%
            }

            .col-lg-push-7 {
                left: 58.3333333333%
            }

            .col-lg-push-8 {
                left: 66.6666666667%
            }

            .col-lg-push-9 {
                left: 75%
            }

            .col-lg-push-10 {
                left: 83.3333333333%
            }

            .col-lg-push-11 {
                left: 91.6666666667%
            }

            .col-lg-push-12 {
                left: 100%
            }

            .col-lg-offset-0 {
                margin-left: 0
            }

            .col-lg-offset-1 {
                margin-left: 8.3333333333%
            }

            .col-lg-offset-2 {
                margin-left: 16.6666666667%
            }

            .col-lg-offset-3 {
                margin-left: 25%
            }

            .col-lg-offset-4 {
                margin-left: 33.3333333333%
            }

            .col-lg-offset-5 {
                margin-left: 41.6666666667%
            }

            .col-lg-offset-6 {
                margin-left: 50%
            }

            .col-lg-offset-7 {
                margin-left: 58.3333333333%
            }

            .col-lg-offset-8 {
                margin-left: 66.6666666667%
            }

            .col-lg-offset-9 {
                margin-left: 75%
            }

            .col-lg-offset-10 {
                margin-left: 83.3333333333%
            }

            .col-lg-offset-11 {
                margin-left: 91.6666666667%
            }

            .col-lg-offset-12 {
                margin-left: 100%
            }
        }
    </style>
</head>
{{--打印出货单模板--}}
@{{#order}}
<div id="">

    <h3 class="" style="text-align: center;">太火鸟出库单</h3>
    <br>
    <div class="row">
        <div class="col-lg-4">收货人: @{{buyer_name}}</div>
        <div class="col-lg-4">手机: @{{ buyer_phone }}</div>
        <div class="col-lg-4">出货日期: @{{ order_send_time }}</div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">固定电话: @{{ buyer_tel }}</div>
        <div class="col-lg-4">订单编号: @{{ number }}</div>
    </div>
    <div class="row">
        <div class="col-lg-10">收货地址: @{{ buyer_province }} @{{ buyer_city }} @{{ buyer_address }}</div>
    </div>
    <br>
    <table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td>商品编号</td>
            <td>商品型号</td>
            <td>商品名称</td>
            <td>商品型号</td>
            <td>数量</td>
        </tr>
        @{{ #order_sku }}
        <tr>
            <td></td>
            <td>@{{ product_number }}</td>
            <td>@{{ number }}</td>
            <td>@{{ name }}</td>
            <td>@{{ mode }}</td>
            <td>@{{ quantity }}</td>
        </tr>
        @{{ /order_sku }}
    </table>
    <br>
    <div class="row">
        <div class="col-lg-10">买家备注: @{{ buyer_summary }}</div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-10">卖家备注: @{{ seller_summary }}</div>
    </div>
</div>
@{{ /order }}
</script>