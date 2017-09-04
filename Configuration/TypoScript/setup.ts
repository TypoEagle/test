plugin.tx_simpleblog_bloglisting {
  view {
    templateRootPaths.0 = EXT:simpleblog/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_simpleblog_bloglisting.view.templateRootPath}
    partialRootPaths.0 = EXT:simpleblog/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_simpleblog_bloglisting.view.partialRootPath}
    layoutRootPaths.0 = EXT:simpleblog/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_simpleblog_bloglisting.view.layoutRootPath}
  }
    settings {
      loginpage = 9
      blog {
          max = 10
      }
    }
  persistence {
		storagePid = 0,3,4,5,6,8
		#storagePid = 2
		#recursive = 1
		updateReferenceIndex = 1
		classes {
			Typovision\Simpleblog\Domain\Model\Blog {
				newRecordStoragePid = 3
			}
			Typovision\Simpleblog\Domain\Model\Post {
				newRecordStoragePid = 4
			}
			Typovision\Simpleblog\Domain\Model\Comment {
				newRecordStoragePid = 5
			}
			Typovision\Simpleblog\Domain\Model\Tag {
				newRecordStoragePid = 6
			}
			Typovision\Simpleblog\Domain\Model\Author {
				mapping {
					tableName = fe_users
					columns {
						name.mapOnProperty = fullname
					}
				}
			}
        }
  }

  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_simpleblog._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-simpleblog table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-simpleblog table th {
        font-weight:bold;
    }

    .tx-simpleblog table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

page {
	includeCSS {
		bootstrap = EXT:simpleblog/Resources/Public/Bootstrap/css/bootstrap.min.css
		simpleblog = EXT:simpleblog/Resources/Public/Css/simpleblog.css
	}
	includeJSlibs {
		jquery = //code.jquery.com/jquery.js
		jquery.external = 1
		bootstrap = EXT:simpleblog/Resources/Public/Bootstrap/js/bootstrap.min.js
	}
}

ajax = PAGE
ajax {
	typeNum = 99
	config {
		disableAllHeaderCode = 1
		additionalHeaders = Content-type:application/json
		admPanel = 0
		debug = 0
	}
	10 < tt_content.list.20.simpleblog_bloglisting
}


plugin.tx_simpleblog_bloglisting {
	_LOCAL_LANG {
		de {
			blog.list.headline = List aller Blogs
		}
	}
}

module.tx_simpleblog_bloglisting < plugin.tx_simpleblog_bloglisting