<div class="modal fade" id="orderModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header text-dark">Fill this form to get your Work Done<button type="button" class="close" data-dismiss="modal"> &times;</button></div>
			<div class="modal-body">
				<form id="orderForm">

					<label class="control-label">Field of Job :</label>
					<div class="form-group">
						<select class="form-control" id="orderField" class="form-control" required>
							<option value="">Choose....</option>
							<option value="Web Development">Web Development</option>
							<option value="App Development">App Development</option>
							<option value="Content Writing">Content Writing</option>
							<option value="Data Entry">Data Entry</option>
						</select>
					</div>



					<label class="control-label">Job Description :</label>
					<div class="form-group"><textarea id="orderDescrip" wrap="hard" placeholder="Give us more details about the job" class="form-control" required></textarea></div>

					<label class="control-label">Expected DueDate :</label>
					<div class="form-group"><input type="date" class="form-control" placeholder="Deadline" id="orderDue" required></div>

					<div class="form-group">
						<label class="control-label">Price :</label>
						<input type="number" id="orderPrice" class="form-control" placeholder="Can be negotiated" required>
					</div>

					<div id="orderResponse"></div><br />
					<div class="modal-footer"></div>
					<br />

					<div><button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>





