var listCampaign = Vue.component('list-campaigns', {

  props: ['campaigns', 'update'],

  template: `
  	<div class="col-12 table-responsive">
        <table class="table table-hover table-striped table-bordered text-center" cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Total Impressions</th>
                    <th>Unique Impressions</th>
                    <th>Status</th>
                    <th v-if="update" class="actions">Actions</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="campaigns.legth===0" class="danger">
                    <td class="text-danger" colspan='5'>No Data Found</td>
                </tr>

                <tr v-else v-for="campaign in campaigns">
                    <td>{{ campaign.name }}</td>
                    <td>{{ campaign.total_impression }}</td>
                    <td>{{ campaign.unique_impression }}</td>
                    <td>{{ campaign.status }}</td>

                    <td v-if="update">
                        <button class="btn btn-outline-success"  data-toggle="modal" data-target="#editModal" title="edit">
                            <i class="fa fa-fw fa-edit" style="transform: scale(1.5);"></i>
                        </button>

                        <button class="btn btn-outline-danger"  data-toggle="modal" data-target="#deleteModal" title="Delete">
                            <i class="fa fa-fw fa-trash" style="transform: scale(1.5);"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  `,

  data: function () {
    return {
      count: 0
    }
  },

  methods: {
	showModal() {
		let element = this.$refs.modal.$el
		$(element).modal('show')
	}
  }

})

new Vue({

	el : '#listCampaign'
})


const createCampaign = Vue.component('create-campaign', {

  props: ['campaignImageCategories', 'createCampaignRoute', 'update'],

  template: `
  	<div class="modal fade" id="addModal" role="dialog">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">

	            <div class="modal-header">
	                <h3> Create Campaign </h3>
	                <button type="button" class="close" data-dismiss="modal">
	                    &times;
	                </button>
	            </div>

	            <div class="modal-body">
	                
	                <form method="POST" @submit.prevent = "onSubmit(createCampaignRoute)" enctype="multipart/form-data">

	                    <div class="row">
	                        <div class="col-12">
	                            <h4 class="title-title text-right"><span class="bg-secondary text-white">Date Details</span></h4>
	                        </div>

	                        <div class="col-12">
	                            <div class="tile">
	                                <div class="tile-body">
	                                    
	                                    <div class="form-group row">
	                                        <label class="control-label col-md-3">Campaign Name</label>
	                                        <div class="col-md-9">
	                                            <input class="form-control is-valid" type="text" v-model="name" placeholder="Enter Campaign name" required="true">
	                                        </div>
	                                    </div>

	                                    <div class="form-group row">
	                                        <label class="control-label col-md-3">Starting Date</label>
	                                        <div class="col-md-9">
	                                            <input class="form-control is-valid datePicker" type="text" v-model="start_date" id="start_date" placeholder="Select Date">
	                                        </div>
	                                    </div>

	                                    <div class="form-group row">
	                                        <label class="control-label col-md-3">Closing Date</label>
	                                        <div class="col-md-9">
	                                            <input class="form-control is-valid datePicker" type="text" v-model="close_date" id="close_date" placeholder="Select Date">
	                                        </div>
	                                    </div>

	                                    <div class="form-group row">
	                                        <label class="control-label col-md-3">Status</label>
	                                        <div class="col-md-9">
	                                            <input type="checkbox" v-model="status" id="status" checked data-toggle="toggle" data-on="<i class='fa fa-check fa-3x'></i>" data-off="<i class='fa fa-times fa-3x'></i>" data-onstyle="success" data-offstyle="danger">
	                                        </div>
	                                    </div>

	                                </div>
	                            </div>
	                        </div>
	                    </div>


	                    <div class="row">
	                        <div class="col-12">
	                            <h4 class="title-title text-right"><span class="bg-secondary text-white">Image Details</span></h4>
	                        </div>
	                        
	                        <div class="col-6" v-for="(campaignImageCategory, index) in campaignImageCategories">
	                            <h4 class="title-title">{{ campaignImageCategory.name }}</h4>
	                            <div class="tile">
	                                <div class="tile-body">

	                                    <div class="form-row">
	                                        <div class="col-md-6 mb-4">
	                                            <label for="validationServer01">Image 1</label>
	                                            <input class="form-control" type="file" accept="image/*" @change="storeImage($event, categoryName(campaignImageCategory.name), 0)">
	                                        </div>
	                                        <div class="col-md-6 mb-4">
	                                            <img class="img-fluid" :id="categoryImageId(campaignImageCategory.name, 0)"/>
	                                        </div>
	                                    </div>  
	                                    
	                                    <div class="form-row">
	                                        <div class="col-md-6 mb-4">
	                                            <label for="validationServer01">Image 2</label>
	                                            <input class="form-control" type="file" accept="image/*" @change="storeImage($event, categoryName(campaignImageCategory.name), 1)">
	                                        </div>
	                                        <div class="col-md-6 mb-4">
	                                            <img class="img-fluid" :id="categoryImageId(campaignImageCategory.name, 1)"/>
	                                        </div>
	                                    </div> 

	                                    <div class="form-row">
	                                        <div class="col-md-6 mb-4">
	                                            <label for="validationServer01">Image 3</label>
	                                            <input class="form-control" type="file" accept="image/*" @change="storeImage($event, categoryName(campaignImageCategory.name), 2)">
	                                        </div>
	                                        <div class="col-md-6 mb-4">
	                                            <img class="img-fluid" :id="categoryImageId(campaignImageCategory.name, 2)"/>
	                                        </div>
	                                    </div> 

	                                    <div class="form-row">
	                                        <div class="col-md-6 mb-4">
	                                            <label for="validationServer01">Image 4</label>
	                                            <input class="form-control" type="file" accept="image/*" @change="storeImage($event, categoryName(campaignImageCategory.name), 3)">
	                                        </div>
	                                        <div class="col-md-6 mb-4">
	                                            <img class="img-fluid" :id="categoryImageId(campaignImageCategory.name, 3)"/>
	                                        </div>
	                                    </div> 

	                                    <div class="form-row">
	                                        <div class="col-md-6 mb-4">
	                                            <label for="validationServer01">Image 5</label>
	                                            <input class="form-control" type="file" accept="image/*" @change="storeImage($event, categoryName(campaignImageCategory.name), 4)">
	                                        </div>
	                                        <div class="col-md-6 mb-4">
	                                            <img class="img-fluid" :id="categoryImageId(campaignImageCategory.name, 4)"/>
	                                        </div>
	                                    </div> 
	                                    

	                                </div>
	                            </div>
	                        </div>

	                    </div>

	                    <br>
	                    
	                    <div class="form-group row">
	                        <div class="col-sm-12">
	                            <button type="submit" class="btn btn-lg btn-block btn-primary">Create</button>
	                        </div>
	                    </div>
	                </form>

	            </div>
	        </div>
	    </div>
	</div>
  `,

  data: function () {
    return {
    	name : null,
    	start_date : null,
    	close_date : null,
    	status : null,
      	imageCategoryPreviews : {}
    }
  },

  methods: {
  	storeImage: function(event, imageCategoryName, imageIndex) {
        // Reference to the DOM input element
        var input = event.target;

        // Ensure that you have a file before attempting to read it
        if (input.files && input.files[0]) {
            
            // create a new FileReader to read this image and convert to base64 format
            const file = input.files[0];

			if (typeof this.imageCategoryPreviews[imageCategoryName] !== 'object') {
				this.imageCategoryPreviews[imageCategoryName] = [];
			}

			this.imageCategoryPreviews[imageCategoryName][imageIndex] = URL.createObjectURL(file); 
			$("#"+imageCategoryName+imageIndex).attr("src",this.imageCategoryPreviews[imageCategoryName][imageIndex]);
        }

        else {

        	this.imageCategoryPreviews[imageCategoryName][imageIndex] = null; 
			$("#"+imageCategoryName+imageIndex).attr("src",'No Image');
        }
    },
	categoryName(name){
		return name.replace(" ", "_", name)
	},
	categoryImageId(name, index){
		return name.replace(" ", "_", name)+index;
	},
	onSubmit(createCampaignRoute) {
      let createCampaignObject = {
        name: this.name,
        start_date: this.start_date,
        close_date: this.close_date,
        status: this.status,
        categoryImages: this.imageCategoryPreviews
      }

      console.log('Before Sending Object :'+createCampaignObject.start_date);

      this.$emit('create-campaign-request', createCampaignObject, createCampaignRoute)
      this.name = null
      this.start_date = null
      this.close_date = null
      this.status = null
      this.imageCategoryPreviews = {}
      $("img").removeAttr("src")
      $('input[type=file]').val(null)
      $('#addModal').modal('toggle')
    }
  }
})

new Vue({

	el: '#createComponent',
    
    methods : {

        createCampaignRequest(createCampaignObject, createCampaignRoute) {
            console.log('After Sending Object :'+createCampaignObject.start_date);
        	// console.log(createCampaignRoute);
		    axios.post(createCampaignRoute).then(response => (console.log(response)));
        }
    },

	mounted(){

	    $( "input#start_date" ).change(function() {
		  	createCampaign.start_date = $(this).val();
		  	// console.log(createCampaign.start_date);
		});

		$( "input#close_date" ).change(function() {
		  	createCampaign.close_date = $(this).val();
		  	// console.log(createCampaign.close_date);
		});

		$( "input#status" ).change(function() {
			if($(this).prop('checked')){
		       createCampaign.status = 'on';
		    }else{
		       createCampaign.status = 'off';
		    }
		});
	}

})